<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\Patient;
use App\Services\OCRService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{
    protected $ocrService;

    public function __construct(OCRService $ocrService)
    {
        $this->ocrService = $ocrService;
    }

    /**
     * Get all prescriptions for authenticated patient
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can access prescriptions'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $prescriptions = $patient->prescriptions()
            ->with('doctor')
            ->orderBy('prescription_date', 'desc')
            ->get();

        return response()->json([
            'prescriptions' => $prescriptions
        ]);
    }

    /**
     * Upload prescription image and process with OCR
     */
    public function upload(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can upload prescriptions'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'doctor_name' => 'nullable|string|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'prescription_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Store the uploaded image
            $imagePath = $request->file('image')->store('prescriptions', 'public');

            // Process with OCR
            $ocrData = $this->ocrService->extractPrescriptionData($request->file('image'));

            // Create prescription record
            $prescription = Prescription::create([
                'patient_id' => $patient->id,
                'prescription_number' => Prescription::generatePrescriptionNumber(),
                'prescription_date' => $request->prescription_date ?? now()->toDateString(),
                'doctor_name' => $request->doctor_name ?? $ocrData['doctor_name'] ?? 'Unknown Doctor',
                'clinic_name' => $request->clinic_name ?? $ocrData['clinic_name'] ?? null,
                'diagnosis' => $ocrData['diagnosis'] ?? null,
                'symptoms' => $ocrData['symptoms'] ?? null,
                'notes' => $ocrData['notes'] ?? null,
                'medicines' => $ocrData['medicines'] ?? [],
                'dosage_instructions' => $ocrData['dosage_instructions'] ?? [],
                'original_image_path' => $imagePath,
                'ocr_data' => $ocrData,
                'is_verified' => false,
            ]);

            return response()->json([
                'message' => 'Prescription uploaded and processed successfully',
                'prescription' => $prescription->load('doctor')
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to process prescription'], 500);
        }
    }

    /**
     * Get specific prescription
     */
    public function show($id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can view prescriptions'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $prescription = $patient->prescriptions()
            ->with('doctor')
            ->find($id);

        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }

        return response()->json([
            'prescription' => $prescription
        ]);
    }

    /**
     * Update prescription (for manual corrections)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can update prescriptions'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $prescription = $patient->prescriptions()->find($id);

        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'doctor_name' => 'nullable|string|max:255',
            'clinic_name' => 'nullable|string|max:255',
            'diagnosis' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
            'medicines' => 'nullable|array',
            'dosage_instructions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $prescription->update($validator->validated());

            return response()->json([
                'message' => 'Prescription updated successfully',
                'prescription' => $prescription->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update prescription'], 500);
        }
    }

    /**
     * Verify prescription
     */
    public function verify($id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can verify prescriptions'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $prescription = $patient->prescriptions()->find($id);

        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }

        try {
            $prescription->verify();

            return response()->json([
                'message' => 'Prescription verified successfully',
                'prescription' => $prescription->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to verify prescription'], 500);
        }
    }

    /**
     * Delete prescription
     */
    public function destroy($id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can delete prescriptions'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $prescription = $patient->prescriptions()->find($id);

        if (!$prescription) {
            return response()->json(['message' => 'Prescription not found'], 404);
        }

        try {
            // Delete the image file
            if ($prescription->original_image_path) {
                Storage::disk('public')->delete($prescription->original_image_path);
            }

            $prescription->delete();

            return response()->json([
                'message' => 'Prescription deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete prescription'], 500);
        }
    }
}
