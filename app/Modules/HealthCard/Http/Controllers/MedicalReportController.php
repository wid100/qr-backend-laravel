<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HealthCard\Models\HealthCard;
use App\Modules\HealthCard\Models\MedicalReport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MedicalReportController extends Controller
{
    /**
     * List all medical reports for a health card
     * GET /api/healthcards/{healthCardId}/medical-reports
     */
    public function index($healthCardId): JsonResponse
    {
        $healthCard = HealthCard::find($healthCardId);

        if (!$healthCard) {
            return response()->json([
                'status' => 'error',
                'message' => 'Health card not found',
            ], 404);
        }

        // Check ownership
        if ($healthCard->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: You can only view medical reports for your own health cards',
            ], 403);
        }

        $reports = MedicalReport::where('health_card_id', $healthCardId)
            ->orderBy('visit_date', 'desc')
            ->get();

        // Format image URLs
        $reports->transform(function ($report) {
            if ($report->prescription_image) {
                $report->prescription_image_url = Storage::url($report->prescription_image);
            }
            if ($report->test_report_image) {
                $report->test_report_image_url = Storage::url($report->test_report_image);
            }
            return $report;
        });

        return response()->json([
            'status' => 'success',
            'data' => $reports,
        ]);
    }

    /**
     * Create a new medical report
     * POST /api/healthcards/{healthCardId}/medical-reports
     */
    public function store(Request $request, $healthCardId): JsonResponse
    {
        $healthCard = HealthCard::find($healthCardId);

        if (!$healthCard) {
            return response()->json([
                'status' => 'error',
                'message' => 'Health card not found',
            ], 404);
        }

        // Check ownership
        if ($healthCard->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: You can only add medical reports to your own health cards',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'visit_date' => 'required|date',
            'doctor_name' => 'required|string|max:255',
            'hospital_name' => 'nullable|string|max:255',
            'medicines' => 'nullable|string',
            'diet_rules' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'test_data' => 'nullable|array',
            'prescription_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'test_report_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $request->only([
                'visit_date', 'doctor_name', 'hospital_name', 'medicines',
                'diet_rules', 'recommendations', 'test_data', 'notes'
            ]);
            $data['health_card_id'] = $healthCardId;

            // Handle prescription image upload
            if ($request->hasFile('prescription_image')) {
                $prescription = $request->file('prescription_image');
                $data['prescription_image'] = $prescription->store('health-cards/prescriptions', 'public');
            }

            // Handle test report image upload
            if ($request->hasFile('test_report_image')) {
                $testReport = $request->file('test_report_image');
                $data['test_report_image'] = $testReport->store('health-cards/test-reports', 'public');
            }

            $medicalReport = MedicalReport::create($data);
            $medicalReport->load('healthCard');

            // Format image URLs
            if ($medicalReport->prescription_image) {
                $medicalReport->prescription_image_url = Storage::url($medicalReport->prescription_image);
            }
            if ($medicalReport->test_report_image) {
                $medicalReport->test_report_image_url = Storage::url($medicalReport->test_report_image);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Medical report created successfully',
                'data' => $medicalReport,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create medical report',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get a single medical report
     * GET /api/medical-reports/{id}
     */
    public function show($id): JsonResponse
    {
        $medicalReport = MedicalReport::with('healthCard')->find($id);

        if (!$medicalReport) {
            return response()->json([
                'status' => 'error',
                'message' => 'Medical report not found',
            ], 404);
        }

        // Check ownership through health card
        if ($medicalReport->healthCard->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: You can only view your own medical reports',
            ], 403);
        }

        // Format image URLs
        if ($medicalReport->prescription_image) {
            $medicalReport->prescription_image_url = Storage::url($medicalReport->prescription_image);
        }
        if ($medicalReport->test_report_image) {
            $medicalReport->test_report_image_url = Storage::url($medicalReport->test_report_image);
        }

        return response()->json([
            'status' => 'success',
            'data' => $medicalReport,
        ]);
    }

    /**
     * Update a medical report
     * PUT /api/medical-reports/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $medicalReport = MedicalReport::with('healthCard')->find($id);

        if (!$medicalReport) {
            return response()->json([
                'status' => 'error',
                'message' => 'Medical report not found',
            ], 404);
        }

        // Check ownership through health card
        if ($medicalReport->healthCard->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: You can only update your own medical reports',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'visit_date' => 'sometimes|required|date',
            'doctor_name' => 'sometimes|required|string|max:255',
            'hospital_name' => 'nullable|string|max:255',
            'medicines' => 'nullable|string',
            'diet_rules' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'test_data' => 'nullable|array',
            'prescription_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'test_report_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $request->only([
                'visit_date', 'doctor_name', 'hospital_name', 'medicines',
                'diet_rules', 'recommendations', 'test_data', 'notes'
            ]);

            // Handle prescription image upload
            if ($request->hasFile('prescription_image')) {
                // Delete old image if exists
                if ($medicalReport->prescription_image) {
                    Storage::disk('public')->delete($medicalReport->prescription_image);
                }
                $prescription = $request->file('prescription_image');
                $data['prescription_image'] = $prescription->store('health-cards/prescriptions', 'public');
            }

            // Handle test report image upload
            if ($request->hasFile('test_report_image')) {
                // Delete old image if exists
                if ($medicalReport->test_report_image) {
                    Storage::disk('public')->delete($medicalReport->test_report_image);
                }
                $testReport = $request->file('test_report_image');
                $data['test_report_image'] = $testReport->store('health-cards/test-reports', 'public');
            }

            $medicalReport->update($data);
            $medicalReport->refresh();

            // Format image URLs
            if ($medicalReport->prescription_image) {
                $medicalReport->prescription_image_url = Storage::url($medicalReport->prescription_image);
            }
            if ($medicalReport->test_report_image) {
                $medicalReport->test_report_image_url = Storage::url($medicalReport->test_report_image);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Medical report updated successfully',
                'data' => $medicalReport,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update medical report',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Delete a medical report
     * DELETE /api/medical-reports/{id}
     */
    public function destroy($id): JsonResponse
    {
        $medicalReport = MedicalReport::with('healthCard')->find($id);

        if (!$medicalReport) {
            return response()->json([
                'status' => 'error',
                'message' => 'Medical report not found',
            ], 404);
        }

        // Check ownership through health card
        if ($medicalReport->healthCard->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: You can only delete your own medical reports',
            ], 403);
        }

        try {
            // Delete associated images
            if ($medicalReport->prescription_image) {
                Storage::disk('public')->delete($medicalReport->prescription_image);
            }
            if ($medicalReport->test_report_image) {
                Storage::disk('public')->delete($medicalReport->test_report_image);
            }

            $medicalReport->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Medical report deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete medical report',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }
}

