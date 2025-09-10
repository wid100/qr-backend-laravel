<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
     * Get patient profile for authenticated user
     */
    public function profile(): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can access this resource'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        return response()->json([
            'patient' => $patient
        ]);
    }

    /**
     * Create patient profile
     */
    public function createProfile(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can create patient profiles'], 403);
        }

        if ($user->patient) {
            return response()->json(['message' => 'Patient profile already exists'], 409);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_type' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $patientData = $validator->validated();
            $patientData['user_id'] = $user->id;
            $patientData['patient_id'] = $this->generatePatientId();

            $patient = Patient::create($patientData);

            return response()->json([
                'message' => 'Patient profile created successfully',
                'patient' => $patient
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create patient profile'], 500);
        }
    }

    /**
     * Update patient profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can update patient profiles'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'blood_type' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $patient->update($validator->validated());

            return response()->json([
                'message' => 'Patient profile updated successfully',
                'patient' => $patient->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update patient profile'], 500);
        }
    }

    /**
     * Get patient medical history
     */
    public function medicalHistory(): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can access medical history'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $medicalHistory = [
            'patient' => $patient,
            'prescriptions' => $patient->prescriptions()->with('doctor')->orderBy('prescription_date', 'desc')->get(),
            'medical_reports' => $patient->medicalReports()->with('doctor')->orderBy('test_date', 'desc')->get(),
        ];

        return response()->json($medicalHistory);
    }

    /**
     * Generate unique patient ID
     */
    private function generatePatientId(): string
    {
        do {
            $patientId = 'PAT' . date('Y') . strtoupper(Str::random(6));
        } while (Patient::where('patient_id', $patientId)->exists());

        return $patientId;
    }
}
