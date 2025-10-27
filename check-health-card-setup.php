<?php
/**
 * Health Card System Diagnostic Script
 * Run this with: php check-health-card-setup.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🔍 HEALTH CARD SYSTEM DIAGNOSTIC\n";
echo "================================\n\n";

// Check 1: Database Connection
echo "1️⃣ Checking Database Connection...\n";
try {
    DB::connection()->getPdo();
    echo "   ✅ Database connected successfully\n";
    echo "   Database: " . DB::connection()->getDatabaseName() . "\n\n";
} catch (\Exception $e) {
    echo "   ❌ Database connection failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Check 2: Users Table
echo "2️⃣ Checking Users...\n";
$users = DB::table('users')->get();
echo "   Total Users: " . $users->count() . "\n";
if ($users->count() > 0) {
    echo "   Recent users:\n";
    foreach ($users->take(5) as $user) {
        $verified = $user->email_verified_at ? '✅ Verified' : '❌ Not Verified';
        $role = $user->role ?? 'No Role';
        echo "   - ID: {$user->id} | {$user->name} ({$user->email}) | Role: {$role} | {$verified}\n";
    }
}
echo "\n";

// Check 3: Patients Table
echo "3️⃣ Checking Patients...\n";
try {
    $patients = DB::table('patients')->get();
    echo "   Total Patients: " . $patients->count() . "\n";
    if ($patients->count() > 0) {
        echo "   Patient Details:\n";
        foreach ($patients as $patient) {
            $user = DB::table('users')->where('id', $patient->user_id)->first();
            echo "   - Patient ID: {$patient->id} | Patient #: {$patient->patient_id} | User: {$user->name} (ID: {$patient->user_id})\n";
        }
    } else {
        echo "   ⚠️  No patients found! You need to create patient profiles.\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Check 4: Health Cards Table
echo "4️⃣ Checking Health Cards...\n";
try {
    $healthCards = DB::table('health_cards')->get();
    echo "   Total Health Cards: " . $healthCards->count() . "\n";
    if ($healthCards->count() > 0) {
        echo "   Health Card Details:\n";
        foreach ($healthCards as $card) {
            $patient = DB::table('patients')->where('id', $card->patient_id)->first();
            $status = $card->is_active ? '🟢 Active' : '🔴 Inactive';
            echo "   - Card #: {$card->card_number} | QR: {$card->qr_code} | Status: {$status} | Patient: {$patient->patient_id}\n";
        }
    } else {
        echo "   ⚠️  No health cards found! You need to generate health cards.\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Check 5: Personal Access Tokens (Sanctum)
echo "5️⃣ Checking Auth Tokens...\n";
try {
    $tokens = DB::table('personal_access_tokens')->get();
    echo "   Total Active Tokens: " . $tokens->count() . "\n";
    if ($tokens->count() > 0) {
        echo "   Recent tokens:\n";
        foreach ($tokens->take(5) as $token) {
            $user = DB::table('users')->where('id', $token->tokenable_id)->first();
            $userName = $user ? $user->name : 'Unknown';
            echo "   - Token: " . substr($token->token, 0, 20) . "... | User: {$userName} | Created: {$token->created_at}\n";
        }
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Check 6: User Role Status
echo "6️⃣ Checking User Roles...\n";
$usersWithRole = DB::table('users')->whereNotNull('role')->get();
$usersWithoutRole = DB::table('users')->whereNull('role')->get();
echo "   Users with role set: " . $usersWithRole->count() . "\n";
echo "   Users without role: " . $usersWithoutRole->count() . "\n";
if ($usersWithoutRole->count() > 0) {
    echo "   ⚠️  Users without role:\n";
    foreach ($usersWithoutRole as $user) {
        echo "   - ID: {$user->id} | {$user->name} ({$user->email})\n";
    }
    echo "   💡 Tip: Set user role to 'patient' for health card access\n";
}
echo "\n";

// Check 7: Prescriptions
echo "7️⃣ Checking Prescriptions...\n";
try {
    $prescriptions = DB::table('prescriptions')->get();
    echo "   Total Prescriptions: " . $prescriptions->count() . "\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Check 8: Medical Reports
echo "8️⃣ Checking Medical Reports...\n";
try {
    $reports = DB::table('medical_reports')->get();
    echo "   Total Medical Reports: " . $reports->count() . "\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Summary & Recommendations
echo "📊 SUMMARY & RECOMMENDATIONS\n";
echo "============================\n\n";

$issues = [];
$solutions = [];

if ($users->count() == 0) {
    $issues[] = "No users found";
    $solutions[] = "Register a user via API: POST /api/health-card/register";
}

if (isset($patients) && $patients->count() == 0) {
    $issues[] = "No patient profiles";
    $solutions[] = "Create patient profile via API: POST /api/health-card/patient/profile";
}

if (isset($healthCards) && $healthCards->count() == 0) {
    $issues[] = "No health cards generated";
    $solutions[] = "Generate health card via API: POST /api/health-card/generate";
}

if ($usersWithoutRole->count() > 0) {
    $issues[] = "Users without role assignment";
    $solutions[] = "Update user role in database: UPDATE users SET role = 'patient' WHERE id = YOUR_USER_ID";
}

if (count($issues) > 0) {
    echo "⚠️  Issues Found:\n";
    foreach ($issues as $i => $issue) {
        echo "   " . ($i + 1) . ". " . $issue . "\n";
    }
    echo "\n";

    echo "💡 Solutions:\n";
    foreach ($solutions as $i => $solution) {
        echo "   " . ($i + 1) . ". " . $solution . "\n";
    }
} else {
    echo "✅ Everything looks good! Your health card system is properly configured.\n";
}

echo "\n";
echo "🔗 API Endpoints:\n";
echo "   - Register: POST http://localhost:8000/api/health-card/register\n";
echo "   - Login: POST http://localhost:8000/api/health-card/login\n";
echo "   - Get User: GET http://localhost:8000/api/health-card/user\n";
echo "   - My Card: GET http://localhost:8000/api/health-card/my-card\n";
echo "   - Generate Card: POST http://localhost:8000/api/health-card/generate\n";
echo "\n";

echo "✅ Diagnostic Complete!\n";

