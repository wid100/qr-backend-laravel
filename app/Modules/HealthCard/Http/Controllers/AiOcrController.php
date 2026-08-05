<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OCRService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AiOcrController extends Controller
{
    protected OCRService $ocr;

    public function __construct(OCRService $ocr)
    {
        $this->ocr = $ocr;
    }

    /**
     * Extract document fields without persisting a record.
     * POST /api/health-card/ai/extract
     *
     * type: prescription | medical_report | health_visit
     */
    public function extract(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:10240',
            'type' => 'required|string|in:prescription,medical_report,health_visit',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $file = $request->file('image');
            $type = $request->input('type');

            if ($type === 'prescription') {
                $data = $this->ocr->extractPrescriptionData($file);
            } elseif ($type === 'medical_report') {
                $data = $this->ocr->extractMedicalReportData($file);
            } else {
                $data = $this->ocr->extractHealthCardVisitData($file);
            }

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 502);
        }
    }
}
