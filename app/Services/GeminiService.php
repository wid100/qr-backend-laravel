<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;
    protected int $timeout;

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.api_key', '');
        $this->model = (string) config('services.gemini.model', 'gemini-2.0-flash');
        $this->baseUrl = rtrim((string) config(
            'services.gemini.base_url',
            'https://generativelanguage.googleapis.com/v1beta'
        ), '/');
        $this->timeout = (int) config('services.gemini.timeout', 90);
    }

    public function isConfigured(): bool
    {
        return $this->apiKey !== '';
    }

    /**
     * Generate plain text from a prompt.
     */
    public function generateText(string $prompt, array $options = []): string
    {
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => $this->generationConfig($options),
        ];

        return $this->extractText($this->request($payload));
    }

    /**
     * Generate and decode a JSON object from a prompt.
     */
    public function generateJson(string $prompt, array $options = []): array
    {
        $options['response_json'] = true;
        $text = $this->generateText($prompt, $options);

        return $this->decodeJson($text);
    }

    /**
     * Multimodal analysis of a local file with a text prompt.
     */
    public function analyzeFile(
        string $absolutePath,
        string $prompt,
        ?string $mimeType = null,
        array $options = []
    ): string {
        if (! is_readable($absolutePath)) {
            throw new RuntimeException('File is not readable for Gemini analysis.');
        }

        $bytes = file_get_contents($absolutePath);
        if ($bytes === false) {
            throw new RuntimeException('Unable to read file for Gemini analysis.');
        }

        $mimeType = $mimeType ?: (mime_content_type($absolutePath) ?: 'application/octet-stream');

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data' => base64_encode($bytes),
                            ],
                        ],
                    ],
                ],
            ],
            'generationConfig' => $this->generationConfig($options),
        ];

        return $this->extractText($this->request($payload));
    }

    /**
     * Multimodal analysis returning decoded JSON.
     */
    public function analyzeFileJson(
        string $absolutePath,
        string $prompt,
        ?string $mimeType = null,
        array $options = []
    ): array {
        $options['response_json'] = true;
        $text = $this->analyzeFile($absolutePath, $prompt, $mimeType, $options);

        return $this->decodeJson($text);
    }

    protected function generationConfig(array $options): array
    {
        $config = [
            'temperature' => $options['temperature'] ?? 0.7,
            'maxOutputTokens' => $options['max_output_tokens'] ?? 4096,
        ];

        $wantsJson = array_key_exists('response_json', $options)
            ? (bool) $options['response_json']
            : false;

        if ($wantsJson) {
            $config['responseMimeType'] = 'application/json';
        }

        return $config;
    }

    protected function request(array $payload): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('Gemini API key is not configured. Set GEMINI_API_KEY in .env');
        }

        $url = "{$this->baseUrl}/models/{$this->model}:generateContent";

        $http = Http::timeout($this->timeout)
            ->withHeaders([
                'x-goog-api-key' => $this->apiKey,
            ])
            ->acceptJson()
            ->asJson();

        $caBundle = $this->resolveCaBundle();
        if ($caBundle) {
            $http = $http->withOptions(['verify' => $caBundle]);
        }

        $response = $http->post($url, $payload);

        if (! $response->successful()) {
            Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'model' => $this->model,
            ]);

            throw new RuntimeException($this->friendlyErrorMessage($response->json() ?? [], $response->body()));
        }

        return $response->json() ?? [];
    }

    protected function friendlyErrorMessage(array $json, string $rawBody): string
    {
        $message = (string) (data_get($json, 'error.message') ?: $rawBody);
        $quotaId = (string) data_get($json, 'error.details.1.violations.0.quotaId', '');

        if ($quotaId === '' && is_array(data_get($json, 'error.details'))) {
            foreach ((array) data_get($json, 'error.details', []) as $detail) {
                $quotaId = (string) data_get($detail, 'violations.0.quotaId', $quotaId);
                if (stripos((string) data_get($detail, 'violations.0.quotaMetric', ''), 'free_tier') !== false) {
                    $quotaId = $quotaId ?: 'FreeTier';
                }
            }
        }

        if (stripos($message, 'free_tier') !== false || stripos($quotaId, 'FreeTier') !== false) {
            return 'Gemini free-tier quota exceeded for model [' . $this->model . ']. '
                . 'This API key is currently being billed against Free Tier quotas. '
                . 'Wait for reset, or set GEMINI_MODEL to another available model '
                . '(e.g. gemini-flash-latest / gemini-3.5-flash-lite), '
                . 'or use an API key from a Google AI Studio project with active paid billing. '
                . 'Original: ' . $message;
        }

        return 'Gemini API request failed: ' . $message;
    }

    /**
     * Resolve a readable CA bundle so Windows/Laragon SSL (cURL error 77) does not break Gemini calls.
     */
    protected function resolveCaBundle(): ?string
    {
        $candidates = array_filter([
            config('services.gemini.ca_bundle'),
            env('CURL_CA_BUNDLE'),
            env('SSL_CERT_FILE'),
            ini_get('curl.cainfo') ?: null,
            ini_get('openssl.cafile') ?: null,
            'F:\\SERVER\\laragon\\etc\\ssl\\cacert.pem',
            'G:\\SERVER\\laragon\\etc\\ssl\\cacert.pem',
            'G:\\SERVER\\etc\\ssl\\cacert.pem',
        ]);

        foreach ($candidates as $path) {
            $path = trim((string) $path, " \t\n\r\0\x0B\"'");
            if ($path !== '' && is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    protected function extractText(array $data): string
    {
        $parts = data_get($data, 'candidates.0.content.parts', []);
        $chunks = [];

        foreach ($parts as $part) {
            if (! empty($part['text'])) {
                $chunks[] = $part['text'];
            }
        }

        $text = trim(implode("\n", $chunks));

        if ($text === '') {
            $blockReason = data_get($data, 'promptFeedback.blockReason')
                ?: data_get($data, 'candidates.0.finishReason');

            throw new RuntimeException(
                'Gemini returned an empty response' . ($blockReason ? " ({$blockReason})" : '') . '.'
            );
        }

        return $text;
    }

    protected function decodeJson(string $text): array
    {
        $clean = trim($text);

        if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $clean, $matches)) {
            $clean = trim($matches[1]);
        }

        $decoded = json_decode($clean, true);

        if (! is_array($decoded)) {
            Log::warning('Gemini JSON decode failed', ['raw' => $text]);
            throw new RuntimeException('Gemini returned invalid JSON.');
        }

        return $decoded;
    }
}
