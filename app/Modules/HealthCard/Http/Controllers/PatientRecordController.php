<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PatientRecordController extends Controller
{
    public function indexPrescriptions(): JsonResponse
    {
        $patient = $this->patientForUser();

        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->orderByDesc('prescription_date')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Prescription $item) => $this->formatPrescription($item));

        return response()->json([
            'status' => 'success',
            'data' => $prescriptions,
        ]);
    }

    public function uploadPrescription(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image'              => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:10240',
            'doctor_name'        => 'nullable|string|max:255',
            'clinic_name'        => 'nullable|string|max:255',
            'prescription_date'  => 'nullable|date',
            'notes'              => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $patient = $this->patientForUser();
        $path = $request->file('image')->store('patient-records/prescriptions', 'public');

        $prescription = Prescription::create([
            'patient_id'           => $patient->id,
            'prescription_number'  => Prescription::generatePrescriptionNumber(),
            'prescription_date'    => $request->input('prescription_date', now()->toDateString()),
            'doctor_name'          => $request->input('doctor_name'),
            'clinic_name'          => $request->input('clinic_name'),
            'notes'                => $request->input('notes'),
            'original_image_path'  => $path,
            'processed_image_path' => $path,
            'medicines'            => [],
            'dosage_instructions'  => [],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Prescription uploaded successfully',
            'data'    => $this->formatPrescription($prescription),
        ], 201);
    }

    public function showPrescription(int $id): JsonResponse
    {
        $prescription = $this->findPrescriptionForUser($id);

        if (! $prescription) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Prescription not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $this->formatPrescription($prescription),
        ]);
    }

    public function updatePrescription(Request $request, int $id): JsonResponse
    {
        $prescription = $this->findPrescriptionForUser($id);

        if (! $prescription) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Prescription not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'doctor_name'         => 'nullable|string|max:255',
            'clinic_name'         => 'nullable|string|max:255',
            'prescription_date'   => 'nullable|date',
            'notes'               => 'nullable|string',
            'medicines'           => 'nullable|array',
            'dosage_instructions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $prescription->update($request->only([
            'doctor_name',
            'clinic_name',
            'prescription_date',
            'notes',
            'medicines',
            'dosage_instructions',
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Prescription updated successfully',
            'data'    => $this->formatPrescription($prescription->fresh()),
        ]);
    }

    public function destroyPrescription(int $id): JsonResponse
    {
        $prescription = $this->findPrescriptionForUser($id);

        if (! $prescription) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Prescription not found',
            ], 404);
        }

        $this->deleteStoredFiles([
            $prescription->original_image_path,
            $prescription->processed_image_path,
        ]);

        $prescription->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Prescription deleted successfully',
        ]);
    }

    public function indexMedicalReports(): JsonResponse
    {
        $patient = $this->patientForUser();

        $reports = MedicalReport::where('patient_id', $patient->id)
            ->orderByDesc('test_date')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (MedicalReport $item) => $this->formatMedicalReport($item));

        return response()->json([
            'status' => 'success',
            'data' => $reports,
        ]);
    }

    public function uploadMedicalReport(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image'        => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:10240',
            'report_type'  => 'required|string|max:255',
            'lab_name'     => 'nullable|string|max:255',
            'doctor_name'  => 'nullable|string|max:255',
            'test_date'    => 'nullable|date',
            'test_notes'   => 'nullable|string',
            'notes'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $patient = $this->patientForUser();
        $path = $request->file('image')->store('patient-records/medical-reports', 'public');

        $report = MedicalReport::create([
            'patient_id'           => $patient->id,
            'report_number'        => MedicalReport::generateReportNumber(),
            'report_type'          => $request->input('report_type'),
            'test_date'            => $request->input('test_date', now()->toDateString()),
            'lab_name'             => $request->input('lab_name'),
            'doctor_name'          => $request->input('doctor_name'),
            'test_notes'           => $request->input('test_notes', $request->input('notes')),
            'original_image_path'  => $path,
            'processed_image_path' => $path,
            'test_results'         => [],
            'normal_ranges'        => [],
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Medical report uploaded successfully',
            'data'    => $this->formatMedicalReport($report),
        ], 201);
    }

    public function showMedicalReport(int $id): JsonResponse
    {
        $report = $this->findMedicalReportForUser($id);

        if (! $report) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Medical report not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $this->formatMedicalReport($report),
        ]);
    }

    public function updateMedicalReport(Request $request, int $id): JsonResponse
    {
        $report = $this->findMedicalReportForUser($id);

        if (! $report) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Medical report not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'report_type' => 'sometimes|required|string|max:255',
            'lab_name'    => 'nullable|string|max:255',
            'doctor_name' => 'nullable|string|max:255',
            'test_date'   => 'nullable|date',
            'test_notes'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $report->update($request->only([
            'report_type',
            'lab_name',
            'doctor_name',
            'test_date',
            'test_notes',
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Medical report updated successfully',
            'data'    => $this->formatMedicalReport($report->fresh()),
        ]);
    }

    public function destroyMedicalReport(int $id): JsonResponse
    {
        $report = $this->findMedicalReportForUser($id);

        if (! $report) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Medical report not found',
            ], 404);
        }

        $this->deleteStoredFiles([
            $report->original_image_path,
            $report->processed_image_path,
        ]);

        $report->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Medical report deleted successfully',
        ]);
    }

    protected function patientForUser(): Patient
    {
        return Patient::findOrCreateForUser(Auth::user());
    }

    protected function findPrescriptionForUser(int $id): ?Prescription
    {
        $patient = $this->patientForUser();

        return Prescription::where('patient_id', $patient->id)->where('id', $id)->first();
    }

    protected function findMedicalReportForUser(int $id): ?MedicalReport
    {
        $patient = $this->patientForUser();

        return MedicalReport::where('patient_id', $patient->id)->where('id', $id)->first();
    }

    protected function deleteStoredFiles(array $paths): void
    {
        foreach ($paths as $path) {
            if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                continue;
            }

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    protected function formatPrescription(Prescription $prescription): array
    {
        $data = $prescription->toArray();
        $data['original_image_path'] = $this->storageUrl($prescription->original_image_path);
        $data['processed_image_path'] = $this->storageUrl($prescription->processed_image_path);

        return $data;
    }

    protected function formatMedicalReport(MedicalReport $report): array
    {
        $data = $report->toArray();
        $data['original_image_path'] = $this->storageUrl($report->original_image_path);
        $data['processed_image_path'] = $this->storageUrl($report->processed_image_path);

        return $data;
    }

    protected function storageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
