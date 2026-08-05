<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$app = require dirname(__DIR__) . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = (string) config('services.gemini.api_key');
$base = rtrim((string) config('services.gemini.base_url'), '/');
$model = (string) config('services.gemini.model');
$ca = config('services.gemini.ca_bundle') ?: 'F:\\SERVER\\laragon\\etc\\ssl\\cacert.pem';

echo 'key_prefix=' . substr($key, 0, 6) . ' len=' . strlen($key) . PHP_EOL;
echo 'configured_model=' . $model . PHP_EOL;
echo 'base=' . $base . PHP_EOL;

function callGemini(string $url, string $key, string $ca, array $payload, bool $useHeader): array
{
    $ch = curl_init($useHeader ? $url : ($url . '?key=' . urlencode($key)));
    $headers = ['Content-Type: application/json'];
    if ($useHeader) {
        $headers[] = 'x-goog-api-key: ' . $key;
    }
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_CAINFO => $ca,
        CURLOPT_TIMEOUT => 45,
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    return compact('code', 'body', 'err');
}

$payload = [
    'contents' => [['parts' => [['text' => 'Reply with exactly: OK']]]],
    'generationConfig' => ['temperature' => 0, 'maxOutputTokens' => 64],
];

// List models
$listUrl = $base . '/models';
$ch = curl_init($listUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['x-goog-api-key: ' . $key],
    CURLOPT_CAINFO => $ca,
    CURLOPT_TIMEOUT => 30,
]);
$listBody = curl_exec($ch);
$listCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "list_models_http={$listCode}" . PHP_EOL;
$listJson = json_decode((string) $listBody, true);
if (isset($listJson['error']['message'])) {
    echo 'list_error=' . $listJson['error']['message'] . PHP_EOL;
}

$candidates = [];
foreach (($listJson['models'] ?? []) as $m) {
    $name = str_replace('models/', '', $m['name'] ?? '');
    if ($name === '') {
        continue;
    }
    if (preg_match('/flash|pro|2\\.5|2\\.0|3\\.|1\\.5/i', $name)) {
        $candidates[] = $name;
        echo "available={$name}" . PHP_EOL;
    }
}

$tryModels = array_values(array_unique(array_filter([
    $model,
    'gemini-2.5-flash',
    'gemini-2.0-flash',
    'gemini-1.5-flash',
    'gemini-2.5-pro',
])));

foreach ($tryModels as $try) {
    $url = "{$base}/models/{$try}:generateContent";
    echo "---- try model={$try} via header ----" . PHP_EOL;
    $res = callGemini($url, $key, $ca, $payload, true);
    echo "http={$res['code']}" . PHP_EOL;
    if ($res['err']) {
        echo 'curl_err=' . $res['err'] . PHP_EOL;
    }
    $json = json_decode((string) $res['body'], true);
    if (isset($json['error']['message'])) {
        echo 'error=' . $json['error']['message'] . PHP_EOL;
        if (! empty($json['error']['details'])) {
            echo 'details=' . json_encode($json['error']['details']) . PHP_EOL;
        }
    } else {
        $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
        echo 'ok_text=' . trim($text) . PHP_EOL;
        break;
    }
}
