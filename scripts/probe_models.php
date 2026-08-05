<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$app = require dirname(__DIR__) . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$key = config('services.gemini.api_key');
$base = rtrim(config('services.gemini.base_url'), '/');
$ca = 'F:\\SERVER\\laragon\\etc\\ssl\\cacert.pem';

$models = [
    'gemini-3.6-flash',
    'gemini-3.5-flash-lite',
    'gemini-3.1-flash-lite',
    'gemini-flash-latest',
    'gemini-3-flash-preview',
    'gemini-3.1-flash-lite-preview',
    'gemini-flash-lite-latest',
];

$payload = json_encode([
    'contents' => [['parts' => [['text' => 'Say OK']]]],
    'generationConfig' => ['maxOutputTokens' => 64],
]);

foreach ($models as $m) {
    $ch = curl_init("{$base}/models/{$m}:generateContent");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'x-goog-api-key: ' . $key,
        ],
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_CAINFO => $ca,
        CURLOPT_TIMEOUT => 40,
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $j = json_decode((string) $body, true);
    if (isset($j['error']['message'])) {
        $msg = preg_replace('/\s+/', ' ', $j['error']['message']);
        echo "{$m} => HTTP {$code} | " . substr($msg, 0, 220) . PHP_EOL;
    } else {
        $text = trim((string) data_get($j, 'candidates.0.content.parts.0.text', ''));
        echo "{$m} => HTTP {$code} | OK: {$text}" . PHP_EOL;
    }
}
