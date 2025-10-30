<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthCard;
use App\Models\Patient;
use App\Services\HealthCardService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HealthCardController extends Controller
{
    protected $healthCardService;

    public function __construct(HealthCardService $healthCardService)
    {
        $this->healthCardService = $healthCardService;
    }

    /**
     * Generate a new health card for the authenticated patient
     */
    public function generate(Request $request): JsonResponse
    {
        $user = Auth::user();

        if (!$user->isPatient()) {
            return response()->json(['message' => 'Only patients can generate health cards'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        if ($patient->healthCard) {
            return response()->json(['message' => 'Health card already exists'], 409);
        }

        try {
            $healthCard = $this->healthCardService->generateHealthCard($patient);

            return response()->json([
                'message' => 'Health card generated successfully',
                'data' => [
                    'id' => $healthCard->id,
                    'card_number' => $healthCard->card_number,
                    'qr_code' => $healthCard->qr_code,
                    'issued_at' => $healthCard->issued_at ? $healthCard->issued_at->toISOString() : now()->toISOString(),
                    'expires_at' => $healthCard->expires_at ? $healthCard->expires_at->toISOString() : null,
                    'is_active' => $healthCard->is_active,
                    'card_image_path' => $healthCard->card_image_path,
                    'card_image_url' => $healthCard->card_image_path ? asset('storage/' . $healthCard->card_image_path) : null,
                ]
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Failed to generate health card', [
                'user_id' => $user->id,
                'patient_id' => $patient->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to generate health card',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get health card by QR code (for doctors to scan)
     */
    public function scanQR(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'qr_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $healthCard = $this->healthCardService->getHealthCardByQRCode($request->qr_code);

        if (!$healthCard) {
            return response()->json(['message' => 'Health card not found or invalid'], 404);
        }

        if (!$this->healthCardService->validateQRCode($request->qr_code)) {
            return response()->json(['message' => 'Health card is expired or inactive'], 400);
        }

        $medicalHistory = $this->healthCardService->getPatientMedicalHistory($healthCard->patient);

        return response()->json([
            'message' => 'Health card scanned successfully',
            'medical_history' => $medicalHistory
        ]);
    }

    /**
     * Get health card by card number
     */
    public function getByCardNumber(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $healthCard = $this->healthCardService->getHealthCardByCardNumber($request->card_number);

        if (!$healthCard) {
            return response()->json(['message' => 'Health card not found'], 404);
        }

        $medicalHistory = $this->healthCardService->getPatientMedicalHistory($healthCard->patient);

        return response()->json([
            'message' => 'Health card found',
            'medical_history' => $medicalHistory
        ]);
    }

    /**
     * Get patient's own health card
     */
    public function show(): JsonResponse
    {
        $user = Auth::user();

        if (!$user->isPatient()) {
            return response()->json(['message' => 'Only patients can view their health card'], 403);
        }

        $patient = $user->patient;

        if (!$patient || !$patient->healthCard) {
            return response()->json(['message' => 'Health card not found'], 404);
        }

        $healthCard = $patient->healthCard;

        return response()->json([
            'health_card' => [
                'id' => $healthCard->id,
                'card_number' => $healthCard->card_number,
                'qr_code' => $healthCard->qr_code,
                'issued_at' => $healthCard->issued_at,
                'expires_at' => $healthCard->expires_at,
                'is_active' => $healthCard->is_active,
                'card_image_url' => asset('storage/' . $healthCard->card_image_path),
            ]
        ]);
    }

    /**
     * Deactivate health card
     */
    public function deactivate(): JsonResponse
    {
        $user = Auth::user();

        if (!$user->isPatient()) {
            return response()->json(['message' => 'Only patients can deactivate their health card'], 403);
        }

        $patient = $user->patient;

        if (!$patient || !$patient->healthCard) {
            return response()->json(['message' => 'Health card not found'], 404);
        }

        $success = $this->healthCardService->deactivateHealthCard($patient->healthCard);

        if ($success) {
            return response()->json(['message' => 'Health card deactivated successfully']);
        }

        return response()->json(['message' => 'Failed to deactivate health card'], 500);
    }

    /**
     * Reactivate health card
     */
    public function reactivate(): JsonResponse
    {
        $user = Auth::user();

        if (!$user->isPatient()) {
            return response()->json(['message' => 'Only patients can reactivate their health card'], 403);
        }

        $patient = $user->patient;

        if (!$patient || !$patient->healthCard) {
            return response()->json(['message' => 'Health card not found'], 404);
        }

        $success = $this->healthCardService->reactivateHealthCard($patient->healthCard);

        if ($success) {
            return response()->json(['message' => 'Health card reactivated successfully']);
        }

        return response()->json(['message' => 'Failed to reactivate health card'], 500);
    }
}
