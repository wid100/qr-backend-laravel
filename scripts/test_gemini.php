<?php

require dirname(__DIR__) . '/vendor/autoload.php';

$app = require dirname(__DIR__) . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$svc = app(App\Services\GeminiService::class);

echo 'configured=' . ($svc->isConfigured() ? 'yes' : 'no') . PHP_EOL;
echo 'model=' . config('services.gemini.model') . PHP_EOL;

try {
    $text = $svc->generateText('Reply with exactly the two characters: OK', [
        'temperature' => 0,
        'max_output_tokens' => 256,
    ]);
    echo 'response=' . $text . PHP_EOL;

    $json = $svc->generateJson('Return JSON: {"ping":"pong"}', [
        'temperature' => 0,
        'max_output_tokens' => 256,
    ]);
    echo 'json=' . json_encode($json) . PHP_EOL;
} catch (Throwable $e) {
    echo 'error=' . $e->getMessage() . PHP_EOL;
}
