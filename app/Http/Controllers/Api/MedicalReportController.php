<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Services\OCRService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MedicalReportController extends Controller
{
    protected $ocrService;

    public function __construct(OCRService $ocrService)
    {
        $this->ocrService = $ocrService;
    }

    /**
     * Get all medical reports for authenticated patient
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can access medical reports'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $medicalReports = $patient->medicalReports()
            ->with('doctor')
            ->orderBy('test_date', 'desc')
            ->get();

        return response()->json([
            'medical_reports' => $medicalReports
        ]);
    }

    /**
     * Upload medical report image and process with OCR
     */
    public function upload(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can upload medical reports'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'report_type' => 'required|string|max:255',
            'lab_name' => 'nullable|string|max:255',
            'doctor_name' => 'nullable|string|max:255',
            'test_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Store the uploaded image
            $imagePath = $request->file('image')->store('medical-reports', 'public');

            // Process with OCR
            $ocrData = $this->ocrService->extractMedicalReportData($request->file('image'));

            // Create medical report record
            $medicalReport = MedicalReport::create([
                'patient_id' => $patient->id,
                'report_number' => MedicalReport::generateReportNumber(),
                'report_type' => $request->report_type,
                'test_date' => $request->test_date ?? now()->toDateString(),
                'lab_name' => $request->lab_name ?? $ocrData['lab_name'] ?? null,
                'doctor_name' => $request->doctor_name ?? $ocrData['doctor_name'] ?? null,
                'test_notes' => $ocrData['test_notes'] ?? null,
                'test_results' => $ocrData['test_results'] ?? [],
                'normal_ranges' => $ocrData['normal_ranges'] ?? [],
                'original_image_path' => $imagePath,
                'ocr_data' => $ocrData,
                'is_verified' => false,
            ]);

            return response()->json([
                'message' => 'Medical report uploaded and processed successfully',
                'medical_report' => $medicalReport->load('doctor')
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to process medical report'], 500);
        }
    }

    /**
     * Get specific medical report
     */
    public function show($id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can view medical reports'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $medicalReport = $patient->medicalReports()
            ->with('doctor')
            ->find($id);

        if (!$medicalReport) {
            return response()->json(['message' => 'Medical report not found'], 404);
        }

        return response()->json([
            'medical_report' => $medicalReport
        ]);
    }

    /**
     * Update medical report (for manual corrections)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can update medical reports'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $medicalReport = $patient->medicalReports()->find($id);

        if (!$medicalReport) {
            return response()->json(['message' => 'Medical report not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'report_type' => 'nullable|string|max:255',
            'lab_name' => 'nullable|string|max:255',
            'doctor_name' => 'nullable|string|max:255',
            'test_notes' => 'nullable|string',
            'test_results' => 'nullable|array',
            'normal_ranges' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $medicalReport->update($validator->validated());

            return response()->json([
                'message' => 'Medical report updated successfully',
                'medical_report' => $medicalReport->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update medical report'], 500);
        }
    }

    /**
     * Verify medical report
     */
    public function verify($id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can verify medical reports'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $medicalReport = $patient->medicalReports()->find($id);

        if (!$medicalReport) {
            return response()->json(['message' => 'Medical report not found'], 404);
        }

        try {
            $medicalReport->verify();

            return response()->json([
                'message' => 'Medical report verified successfully',
                'medical_report' => $medicalReport->fresh()
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to verify medical report'], 500);
        }
    }

    /**
     * Delete medical report
     */
    public function destroy($id): JsonResponse
    {
        $user = Auth::user();

        if ($user->role !== 'patient') {
            return response()->json(['message' => 'Only patients can delete medical reports'], 403);
        }

        $patient = $user->patient;

        if (!$patient) {
            return response()->json(['message' => 'Patient profile not found'], 404);
        }

        $medicalReport = $patient->medicalReports()->find($id);

        if (!$medicalReport) {
            return response()->json(['message' => 'Medical report not found'], 404);
        }

        try {
            // Delete the image file
            if ($medicalReport->original_image_path) {
                Storage::disk('public')->delete($medicalReport->original_image_path);
            }

            $medicalReport->delete();

            return response()->json([
                'message' => 'Medical report deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete medical report'], 500);
        }
    }
}
