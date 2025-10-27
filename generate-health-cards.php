<?php
/**
 * Generate Health Cards for Existing Patients
 * Run this with: php generate-health-cards.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Patient;
use App\Models\HealthCard;

echo "🏥 GENERATING HEALTH CARDS\n";
echo "==========================\n\n";

// Get all patients without health cards
$patients = Patient::doesntHave('healthCard')->get();

if ($patients->count() == 0) {
    echo "✅ All patients already have health cards!\n";

    // Show existing cards
    $cards = HealthCard::with('patient')->get();
    if ($cards->count() > 0) {
        echo "\n📋 Existing Health Cards:\n";
        foreach ($cards as $card) {
            $status = $card->is_active ? '🟢 Active' : '🔴 Inactive';
            echo "   - {$card->card_number} | Patient: {$card->patient->first_name} {$card->patient->last_name} | {$status}\n";
        }
    }
    exit(0);
}

echo "Found {$patients->count()} patient(s) without health cards.\n\n";

foreach ($patients as $patient) {
    echo "Processing Patient #{$patient->id} - {$patient->first_name} {$patient->last_name}...\n";

    try {
        // Generate card number
        do {
            $cardNumber = 'HC' . date('Y') . strtoupper(\Illuminate\Support\Str::random(8));
        } while (HealthCard::where('card_number', $cardNumber)->exists());

        // Generate QR code
        do {
            $qrCode = 'QR' . time() . strtoupper(\Illuminate\Support\Str::random(6));
        } while (HealthCard::where('qr_code', $qrCode)->exists());

        // Create health card
        $healthCard = HealthCard::create([
            'patient_id' => $patient->id,
            'card_number' => $cardNumber,
            'qr_code' => $qrCode,
            'is_active' => true,
            'issued_at' => now(),
            'expires_at' => null, // No expiry
        ]);

        echo "   ✅ Health Card Generated!\n";
        echo "      - Card Number: {$healthCard->card_number}\n";
        echo "      - QR Code: {$healthCard->qr_code}\n";
        echo "      - Status: " . ($healthCard->is_active ? '🟢 Active' : '🔴 Inactive') . "\n";
        echo "      - Issued: {$healthCard->issued_at}\n\n";

    } catch (\Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n\n";
    }
}

echo "✅ Health Card Generation Complete!\n\n";

// Show summary
$totalCards = HealthCard::count();
$activeCards = HealthCard::where('is_active', true)->count();
$inactiveCards = HealthCard::where('is_active', false)->count();

echo "📊 SUMMARY:\n";
echo "   Total Health Cards: {$totalCards}\n";
echo "   Active: {$activeCards}\n";
echo "   Inactive: {$inactiveCards}\n\n";

echo "🎉 Done! Now try accessing: http://localhost:8000/api/health-card/my-card\n";

