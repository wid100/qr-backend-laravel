<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HealthCardsSeeder extends Seeder
{
    public function run(): void
    {
        // Find demo patient created by PatientsSeeder
        $userId = DB::table('users')->where('email', 'demo.patient@example.com')->value('id');
        if (!$userId) return;
        $patientId = DB::table('patients')->where('user_id', $userId)->value('id');
        if (!$patientId) return;

        // Upsert a demo health card
        $exists = DB::table('health_cards')->where('patient_id', $patientId)->exists();
        if (!$exists) {
            DB::table('health_cards')->insert([
                'patient_id' => $patientId,
                'card_number' => 'HC-' . strtoupper(Str::random(10)),
                'qr_code' => 'QR-' . strtoupper(Str::random(24)),
                'barcode' => null,
                'card_image_path' => null,
                'is_active' => true,
                'issued_at' => now(),
                'expires_at' => now()->addYear(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
