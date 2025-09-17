<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PatientsSeeder extends Seeder
{
    public function run(): void
    {
        // Create or get a demo user
        $userId = DB::table('users')->where('email', 'demo.patient@example.com')->value('id');
        if (!$userId) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Demo Patient',
                'email' => 'demo.patient@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create patient for that user
        $patientId = DB::table('patients')->where('user_id', $userId)->value('id');
        if (!$patientId) {
            $patientId = DB::table('patients')->insertGetId([
                'user_id' => $userId,
                'patient_id' => 'PAT-' . Str::upper(Str::random(8)),
                'first_name' => 'Demo',
                'last_name' => 'Patient',
                'date_of_birth' => '1995-01-15',
                'gender' => 'female',
                'phone' => '01700000000',
                'address' => '123 Demo Street, City',
                'emergency_contact_name' => 'John Doe',
                'emergency_contact_phone' => '01800000000',
                'medical_history' => 'No major illness.',
                'allergies' => 'Pollen',
                'current_medications' => 'None',
                'blood_type' => 'O+',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Store reference for other seeders
        cache()->put('demo_patient_id', $patientId, 300);
    }
}
