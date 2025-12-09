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
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

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
            return $this->errorResponse('Health card not found', 404);
        }

        if ($healthCard->user_id !== Auth::id()) {
            return $this->errorResponse('Unauthorized: You can only view medical reports for your own health cards', 403);
        }

        $reports = MedicalReport::where('health_card_id', $healthCardId)
            ->orderBy('visit_date', 'desc')
            ->get();

        // Format image URLs
        $reports->transform(function ($report) {
            $this->formatImageUrls($report);
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
            return $this->errorResponse('Health card not found', 404);
        }

        if ($healthCard->user_id !== Auth::id()) {
            return $this->errorResponse('Unauthorized: You can only add medical reports to your own health cards', 403);
        }

        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $this->prepareData($request, $healthCardId);

            // Handle prescription images
            $prescriptionImages = $this->processMultipleImages($request, 'prescription_image', 'health-cards/prescriptions');
            if (!empty($prescriptionImages)) {
                $data['prescription_image'] = count($prescriptionImages) > 1
                    ? json_encode($prescriptionImages)
                    : $prescriptionImages[0];
            }

            // Handle test report images
            $testReportImages = $this->processMultipleImages($request, 'test_report_image', 'health-cards/test-reports');
            if (!empty($testReportImages)) {
                $data['test_report_image'] = count($testReportImages) > 1
                    ? json_encode($testReportImages)
                    : $testReportImages[0];
            }

            $medicalReport = MedicalReport::create($data);
            $medicalReport->load('healthCard');

            $this->formatImageUrls($medicalReport);

            return response()->json([
                'status' => 'success',
                'message' => 'Medical report created successfully',
                'data' => $medicalReport,
            ], 201);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create medical report',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * Get a single medical report
     * GET /api/healthcards/medical-reports/{id}
     */
    public function show($id): JsonResponse
    {
        $medicalReport = MedicalReport::with('healthCard')->find($id);

        if (!$medicalReport) {
            return $this->errorResponse('Medical report not found', 404);
        }

        if ($medicalReport->healthCard->user_id !== Auth::id()) {
            return $this->errorResponse('Unauthorized: You can only view your own medical reports', 403);
        }

        $this->formatImageUrls($medicalReport);

        return response()->json([
            'status' => 'success',
            'data' => $medicalReport,
        ]);
    }

    /**
     * Update a medical report
     * PUT /api/healthcards/medical-reports/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $medicalReport = MedicalReport::with('healthCard')->find($id);

        if (!$medicalReport) {
            return $this->errorResponse('Medical report not found', 404);
        }

        if ($medicalReport->healthCard->user_id !== Auth::id()) {
            return $this->errorResponse('Unauthorized: You can only update your own medical reports', 403);
        }

        $validator = $this->validateUpdateRequest($request);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $data = $this->prepareUpdateData($request);

            // Handle prescription images
            // Laravel handles array fields: prescription_image[] becomes prescription_image in request
            $prescriptionFiles = $request->file('prescription_image');

            if ($prescriptionFiles) {
                $this->deleteOldImages($medicalReport->prescription_image);
                $prescriptionImages = $this->processMultipleImages($request, 'prescription_image', 'health-cards/prescriptions');
                if (!empty($prescriptionImages)) {
                    $data['prescription_image'] = count($prescriptionImages) > 1
                        ? json_encode($prescriptionImages)
                        : $prescriptionImages[0];
                }
            }

            // Handle test report images
            // Laravel handles array fields: test_report_image[] becomes test_report_image in request
            $testReportFiles = $request->file('test_report_image');

            if ($testReportFiles) {
                $this->deleteOldImages($medicalReport->test_report_image);
                $testReportImages = $this->processMultipleImages($request, 'test_report_image', 'health-cards/test-reports');
                if (!empty($testReportImages)) {
                    $data['test_report_image'] = count($testReportImages) > 1
                        ? json_encode($testReportImages)
                        : $testReportImages[0];
                }
            }

            $medicalReport->update($data);
            $medicalReport->refresh();

            $this->formatImageUrls($medicalReport);

            return response()->json([
                'status' => 'success',
                'message' => 'Medical report updated successfully',
                'data' => $medicalReport,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update medical report',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * Delete a medical report
     * DELETE /api/healthcards/medical-reports/{id}
     */
    public function destroy($id): JsonResponse
    {
        $medicalReport = MedicalReport::with('healthCard')->find($id);

        if (!$medicalReport) {
            return $this->errorResponse('Medical report not found', 404);
        }

        if ($medicalReport->healthCard->user_id !== Auth::id()) {
            return $this->errorResponse('Unauthorized: You can only delete your own medical reports', 403);
        }

        try {
            // Delete associated images
            $this->deleteOldImages($medicalReport->prescription_image);
            $this->deleteOldImages($medicalReport->test_report_image);

            $medicalReport->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Medical report deleted successfully',
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete medical report',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * Validate request for creating medical report
     */
    private function validateRequest(Request $request)
    {
        $requestData = array_merge($request->post(), $request->allFiles());

        // Build dynamic validation rules based on whether images are arrays or single files
        $rules = [
            'visit_date' => 'required|date',
            'doctor_name' => 'required|string|max:255',
            'hospital_name' => 'nullable|string|max:255',
            'medicines' => 'nullable|string',
            'diet_rules' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'test_data' => 'nullable|string',
            'notes' => 'nullable|string',
        ];

        // Handle prescription_image validation (single or array)
        $prescriptionImage = $request->file('prescription_image');
        if (is_array($prescriptionImage)) {
            $rules['prescription_image'] = 'nullable|array';
            $rules['prescription_image.*'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } else {
            $rules['prescription_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }

        // Handle test_report_image validation (single or array)
        $testReportImage = $request->file('test_report_image');
        if (is_array($testReportImage)) {
            $rules['test_report_image'] = 'nullable|array';
            $rules['test_report_image.*'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } else {
            $rules['test_report_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }

        return Validator::make($requestData, $rules);
    }

    /**
     * Validate request for updating medical report
     */
    private function validateUpdateRequest(Request $request)
    {
        // Use all() instead of post() for PUT requests with FormData
        // post() returns empty array for PUT requests with multipart/form-data
        $allData = $request->all();
        $files = $request->allFiles();

        // Merge all data including files
        $requestData = array_merge($allData, $files);

        // Build dynamic validation rules based on whether images are arrays or single files
        $rules = [
            'visit_date' => 'sometimes|required|date',
            'doctor_name' => 'sometimes|required|string|max:255',
            'hospital_name' => 'nullable|string|max:255',
            'medicines' => 'nullable|string',
            'diet_rules' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'test_data' => 'nullable|string',
            'notes' => 'nullable|string',
        ];

        // Handle prescription_image validation (single or array)
        $prescriptionImage = $request->file('prescription_image');
        if (is_array($prescriptionImage)) {
            $rules['prescription_image'] = 'nullable|array';
            $rules['prescription_image.*'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } else {
            $rules['prescription_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }

        // Handle test_report_image validation (single or array)
        $testReportImage = $request->file('test_report_image');
        if (is_array($testReportImage)) {
            $rules['test_report_image'] = 'nullable|array';
            $rules['test_report_image.*'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        } else {
            $rules['test_report_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
        }

        return Validator::make($requestData, $rules);
    }

    /**
     * Prepare data for creating medical report
     */
    private function prepareData(Request $request, $healthCardId): array
    {
        $data = [
            'visit_date' => $request->post('visit_date'),
            'doctor_name' => $request->post('doctor_name'),
            'hospital_name' => $request->post('hospital_name') ?: null,
            'medicines' => $request->post('medicines') ?: null,
            'diet_rules' => $request->post('diet_rules') ?: null,
            'recommendations' => $request->post('recommendations') ?: null,
            'notes' => $request->post('notes') ?: null,
            'health_card_id' => $healthCardId,
        ];

        // Handle test_data - parse JSON string if provided
        $testDataInput = $request->post('test_data');
        if ($testDataInput) {
            if (is_string($testDataInput)) {
                $decoded = json_decode($testDataInput, true);
                $data['test_data'] = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
            } else {
                $data['test_data'] = $testDataInput;
            }
        } else {
            $data['test_data'] = null;
        }

        return $data;
    }

    /**
     * Prepare data for updating medical report
     */
    private function prepareUpdateData(Request $request): array
    {
        $data = [];

        // Get all input data (including empty strings)
        // Check if key exists in request by checking input() with default null
        $allInput = $request->all();

        // Required fields - always update if present
        if (array_key_exists('visit_date', $allInput)) {
            $data['visit_date'] = $request->input('visit_date');
        }
        if (array_key_exists('doctor_name', $allInput)) {
            $data['doctor_name'] = $request->input('doctor_name');
        }

        // Optional fields - update if present (even if empty/null)
        if (array_key_exists('hospital_name', $allInput)) {
            $value = $request->input('hospital_name');
            $data['hospital_name'] = ($value !== null && $value !== '') ? $value : null;
        }
        if (array_key_exists('medicines', $allInput)) {
            $value = $request->input('medicines');
            $data['medicines'] = ($value !== null && $value !== '') ? $value : null;
        }
        if (array_key_exists('diet_rules', $allInput)) {
            $value = $request->input('diet_rules');
            $data['diet_rules'] = ($value !== null && $value !== '') ? $value : null;
        }
        if (array_key_exists('recommendations', $allInput)) {
            $value = $request->input('recommendations');
            $data['recommendations'] = ($value !== null && $value !== '') ? $value : null;
        }
        if (array_key_exists('notes', $allInput)) {
            $value = $request->input('notes');
            $data['notes'] = ($value !== null && $value !== '') ? $value : null;
        }

        // Handle test_data
        if (array_key_exists('test_data', $allInput)) {
            $testData = $request->input('test_data');
            if ($testData === null || $testData === '') {
                $data['test_data'] = null;
            } elseif (is_string($testData)) {
                $decoded = json_decode($testData, true);
                $data['test_data'] = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
            } else {
                $data['test_data'] = $testData;
            }
        }

        return $data;
    }

    /**
     * Process multiple images using Intervention Image
     * Supports both single file and array of files
     */
    private function processMultipleImages(Request $request, string $fieldName, string $storagePath): array
    {
        $files = $request->file($fieldName);

        if (!$files) {
            return [];
        }

        $processedImages = [];
        $filesArray = is_array($files) ? $files : [$files];

        foreach ($filesArray as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            try {
                // Generate unique filename
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $uniqueName = Str::slug($originalName) . '_' . Str::random(20) . '_' . time() . '.' . $extension;

                // Ensure storage directory exists
                $fullStoragePath = storage_path('app/public/' . $storagePath);
                if (!file_exists($fullStoragePath)) {
                    mkdir($fullStoragePath, 0755, true);
                }

                // Process image with Intervention Image
                $image = Image::make($file);

                // Resize if image is too large (max width 1920px, maintain aspect ratio)
                if ($image->width() > 1920) {
                    $image->resize(1920, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Save optimized image directly to storage
                $savePath = $fullStoragePath . '/' . $uniqueName;
                $image->save($savePath, 85);

                // Store relative path for database
                $relativePath = $storagePath . '/' . $uniqueName;
                $processedImages[] = $relativePath;

            } catch (\Exception $e) {
                // Continue processing other images on error
                continue;
            }
        }

        return $processedImages;
    }

    /**
     * Delete old images (supports both single and JSON array format)
     */
    private function deleteOldImages($imageField): void
    {
        if (!$imageField) {
            return;
        }

        // Check if it's JSON array
        $decoded = json_decode($imageField, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            // Multiple images
            foreach ($decoded as $path) {
                Storage::disk('public')->delete($path);
            }
        } else {
            // Single image
            Storage::disk('public')->delete($imageField);
        }
    }

    /**
     * Format image URLs for response (supports multiple images)
     */
    private function formatImageUrls($medicalReport): void
    {
        // Handle prescription images
        if ($medicalReport->prescription_image) {
            $decoded = json_decode($medicalReport->prescription_image, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $medicalReport->prescription_images = array_map(function($path) {
                    return Storage::url($path);
                }, $decoded);
                $medicalReport->prescription_image_url = $medicalReport->prescription_images[0] ?? null;
            } else {
                $medicalReport->prescription_image_url = Storage::url($medicalReport->prescription_image);
                $medicalReport->prescription_images = [$medicalReport->prescription_image_url];
            }
        }

        // Handle test report images
        if ($medicalReport->test_report_image) {
            $decoded = json_decode($medicalReport->test_report_image, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $medicalReport->test_report_images = array_map(function($path) {
                    return Storage::url($path);
                }, $decoded);
                $medicalReport->test_report_image_url = $medicalReport->test_report_images[0] ?? null;
            } else {
                $medicalReport->test_report_image_url = Storage::url($medicalReport->test_report_image);
                $medicalReport->test_report_images = [$medicalReport->test_report_image_url];
            }
        }
    }

    /**
     * Return error response
     */
    private function errorResponse(string $message, int $status = 400, ?string $error = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($error && config('app.debug')) {
            $response['error'] = $error;
        }

        return response()->json($response, $status);
    }
}
