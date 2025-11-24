<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HealthCard\Models\HealthCard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class HealthCardController extends Controller
{
    /**
     * List all health cards for the authenticated user
     * GET /api/healthcards
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);

        $cards = HealthCard::where('user_id', Auth::id())
            ->withCount('medicalReports')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $cards->items(),
            'meta' => [
                'current_page' => $cards->currentPage(),
                'last_page' => $cards->lastPage(),
                'per_page' => $cards->perPage(),
                'total' => $cards->total(),
            ],
        ]);
    }

    /**
     * Create a new health card
     * POST /api/healthcards
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'person_name' => 'required|string|max:255',
            'person_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'gender' => 'nullable|in:male,female,other',
            'card_type' => 'required|in:pregnant,child,adult,senior',
            'expected_delivery_date' => 'nullable|date|required_if:card_type,pregnant',
            'emergency_contact' => 'nullable|string',
            'allergies' => 'nullable|string',
            'username' => 'nullable|string|max:255|unique:health_cards,username',
            'access_type' => ['nullable', Rule::in(['private', 'protected', 'public'])],
            'meta' => 'nullable|string', // JSON string for color customization
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('person_photo')) {
                $photo = $request->file('person_photo');

                // Validate file
                if (!$photo->isValid()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid file uploaded',
                    ], 422);
                }

                // Store file
                $photoPath = $photo->store('health-cards/photos', 'public');

                // Verify file was stored
                if (!$photoPath || !Storage::disk('public')->exists($photoPath)) {
                    Log::error('File upload failed', [
                        'original_name' => $photo->getClientOriginalName(),
                        'size' => $photo->getSize(),
                        'mime_type' => $photo->getMimeType(),
                    ]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to store image file',
                    ], 500);
                }

                Log::info('Photo uploaded successfully', [
                    'path' => $photoPath,
                    'size' => $photo->getSize(),
                    'url' => Storage::url($photoPath),
                ]);
            }

            // Generate slug from person name
            $slug = HealthCard::generateSlug($request->person_name);

            // Parse meta if provided (JSON string)
            $meta = null;
            if ($request->has('meta') && $request->meta) {
                $meta = is_string($request->meta) ? json_decode($request->meta, true) : $request->meta;
            }

            $healthCard = HealthCard::create([
                'user_id' => Auth::id(),
                'person_name' => $request->person_name,
                'person_photo' => $photoPath,
                'date_of_birth' => $request->date_of_birth,
                'blood_group' => $request->blood_group,
                'gender' => $request->gender,
                'card_type' => $request->card_type,
                'expected_delivery_date' => $request->expected_delivery_date,
                'emergency_contact' => $request->emergency_contact,
                'allergies' => $request->allergies,
                'slug' => $slug,
                'username' => $request->username,
                'qr_code_hash' => HealthCard::generateQrCodeHash(),
                'access_type' => $request->access_type ?? 'private',
                'meta' => $meta,
            ]);

            // Load relationship
            $healthCard->load('user');

            // Format photo URL if exists
            if ($healthCard->person_photo) {
                $healthCard->person_photo_url = Storage::url($healthCard->person_photo);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Health card created successfully',
                'data' => $healthCard,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating health card', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['person_photo']),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create health card',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get a single health card
     * GET /api/healthcards/{id}
     */
    public function show($id): JsonResponse
    {
        $healthCard = HealthCard::with(['user', 'medicalReports' => function($query) {
            $query->orderBy('visit_date', 'desc');
        }])->find($id);

        if (!$healthCard) {
            return response()->json([
                'status' => 'error',
                'message' => 'Health card not found',
            ], 404);
        }

        // Check access permissions
        if ($healthCard->user_id !== Auth::id()) {
            if (!$healthCard->isAccessible()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized: You do not have access to this health card',
                ], 403);
            }
        }

        // Format photo URL if exists
        if ($healthCard->person_photo) {
            $healthCard->person_photo_url = Storage::url($healthCard->person_photo);
        }

        return response()->json([
            'status' => 'success',
            'data' => $healthCard,
        ]);
    }

    /**
     * Update a health card (owner only)
     * PUT /api/healthcards/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $healthCard = HealthCard::find($id);

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
                'message' => 'Unauthorized: You can only update your own health cards',
            ], 403);
        }

        // For FormData with _method=PUT, merge post() and files() to ensure all data is included
        // $request->post() works correctly with FormData for POST requests
        $requestData = array_merge($request->post(), $request->allFiles());

        $validator = Validator::make($requestData, [
            'person_name' => 'required|string|max:255',
            'person_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'gender' => 'nullable|in:male,female,other',
            'card_type' => 'required|in:pregnant,child,adult,senior',
            'expected_delivery_date' => 'nullable|date',
            'emergency_contact' => 'nullable|string',
            'allergies' => 'nullable|string',
            'username' => 'nullable|string|max:255|unique:health_cards,username,' . $id,
            'access_type' => ['required', Rule::in(['private', 'protected', 'public'])],
            'meta' => 'nullable|string', // JSON string for color customization
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            Log::info('Update request received', [
                'id' => $id,
                'request_data_keys' => array_keys($requestData),
                'has_file' => $request->hasFile('person_photo'),
                'all_files' => array_keys($request->allFiles()),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type'),
            ]);

            // Prepare data array - use the validated requestData
            $data = [];

            // Required fields - always include if present
            $data['person_name'] = $requestData['person_name'] ?? null;
            $data['card_type'] = $requestData['card_type'] ?? null;
            $data['access_type'] = $requestData['access_type'] ?? null;

            // Optional fields - convert empty strings to null
            $optionalFields = ['date_of_birth', 'blood_group', 'gender', 'expected_delivery_date',
                              'emergency_contact', 'allergies', 'username', 'meta'];
            foreach ($optionalFields as $field) {
                $value = $requestData[$field] ?? null;
                $data[$field] = ($value === '' || $value === null) ? null : $value;
            }

            // Handle photo upload - check both hasFile() and requestData array
            $hasPhoto = $request->hasFile('person_photo');
            $photoInData = isset($requestData['person_photo']);

            Log::info('Photo upload check', [
                'hasFile' => $hasPhoto,
                'in_requestData' => $photoInData,
                'allFiles_keys' => array_keys($request->allFiles()),
            ]);

            if ($hasPhoto || $photoInData) {
                // Try to get file from request first, then from requestData
                $photo = null;
                if ($hasPhoto) {
                    $photo = $request->file('person_photo');
                } elseif ($photoInData && $requestData['person_photo'] instanceof \Illuminate\Http\UploadedFile) {
                    $photo = $requestData['person_photo'];
                }

                if (!$photo) {
                    Log::warning('Photo field exists but file is null', [
                        'hasFile' => $hasPhoto,
                        'in_requestData' => $photoInData,
                        'requestData_type' => isset($requestData['person_photo']) ? gettype($requestData['person_photo']) : 'not_set',
                    ]);
                } else {
                    Log::info('Photo file received', [
                        'original_name' => $photo->getClientOriginalName(),
                        'size' => $photo->getSize(),
                        'mime_type' => $photo->getMimeType(),
                    ]);

                    // Validate file
                    if (!$photo->isValid()) {
                        Log::error('Invalid file uploaded', [
                            'error' => $photo->getError(),
                        ]);
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Invalid file uploaded',
                        ], 422);
                    }

                    // Delete old photo if exists
                    if ($healthCard->person_photo && Storage::disk('public')->exists($healthCard->person_photo)) {
                        Storage::disk('public')->delete($healthCard->person_photo);
                        Log::info('Old photo deleted', ['path' => $healthCard->person_photo]);
                    }

                    // Store new file
                    try {
                        $photoPath = $photo->store('health-cards/photos', 'public');

                        if (!$photoPath) {
                            throw new \Exception('store() method returned null or false');
                        }

                        Log::info('File stored', [
                            'path' => $photoPath,
                            'exists' => Storage::disk('public')->exists($photoPath),
                        ]);
                    } catch (\Exception $e) {
                        Log::error('File storage exception', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'original_name' => $photo->getClientOriginalName(),
                            'size' => $photo->getSize(),
                        ]);
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to store image file: ' . $e->getMessage(),
                        ], 500);
                    }

                    // Verify file was stored
                    if (!Storage::disk('public')->exists($photoPath)) {
                        Log::error('File upload failed - file does not exist after store', [
                            'path' => $photoPath,
                            'original_name' => $photo->getClientOriginalName(),
                            'size' => $photo->getSize(),
                            'mime_type' => $photo->getMimeType(),
                            'storage_path' => storage_path('app/public'),
                        ]);
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to store image file - file not found after upload',
                        ], 500);
                    }

                    $data['person_photo'] = $photoPath;
                    Log::info('Photo uploaded successfully', [
                        'path' => $photoPath,
                        'size' => $photo->getSize(),
                        'url' => Storage::url($photoPath),
                    ]);
                }
            }

            // Update slug if person_name changed
            if (isset($data['person_name']) && $data['person_name'] !== $healthCard->person_name) {
                $data['slug'] = HealthCard::generateSlug($data['person_name']);
                Log::info('Slug updated', ['old' => $healthCard->slug, 'new' => $data['slug']]);
            }

            // Parse meta if provided (JSON string)
            if ($request->has('meta') && $request->meta) {
                try {
                    $meta = is_string($request->meta) ? json_decode($request->meta, true) : $request->meta;
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $data['meta'] = $meta;
                        Log::info('Meta data parsed successfully');
                    } else {
                        Log::warning('Invalid JSON in meta field', ['meta' => $request->meta, 'error' => json_last_error_msg()]);
                    }
                } catch (\Exception $e) {
                    Log::warning('Error parsing meta field', ['error' => $e->getMessage()]);
                }
            }

            Log::info('Data to update', ['data' => $data]);

            // Update the health card
            $updated = $healthCard->update($data);

            if (!$updated) {
                Log::error('Update failed - model update returned false');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update health card',
                ], 500);
            }

            $healthCard->refresh();

            Log::info('Health card updated successfully', [
                'id' => $healthCard->id,
                'updated_fields' => array_keys($data),
            ]);

            // Format photo URL if exists
            if ($healthCard->person_photo) {
                $healthCard->person_photo_url = Storage::url($healthCard->person_photo);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Health card updated successfully',
                'data' => $healthCard,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating health card', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update health card',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Delete a health card (owner only)
     * DELETE /api/healthcards/{id}
     */
    public function destroy($id): JsonResponse
    {
        $healthCard = HealthCard::find($id);

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
                'message' => 'Unauthorized: You can only delete your own health cards',
            ], 403);
        }

        try {
            $healthCard->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Health card deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete health card',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Get health card by QR hash (public endpoint based on access_type)
     * GET /api/healthcards/qr/{hash}
     */
    public function getByQrHash($hash): JsonResponse
    {
        $healthCard = HealthCard::where('qr_code_hash', $hash)->first();

        if (!$healthCard) {
            return response()->json([
                'status' => 'error',
                'message' => 'Health card not found',
            ], 404);
        }

        // Check access permissions
        $isOwner = auth()->check() && auth()->id() === $healthCard->user_id;

        if (!$isOwner && !$healthCard->isAccessible()) {
            return response()->json([
                'status' => 'error',
                'message' => 'This health card is private',
            ], 403);
        }

        // Format photo URL if exists
        if ($healthCard->person_photo) {
            $healthCard->person_photo_url = Storage::url($healthCard->person_photo);
        }

        // Return basic info for public/protected cards, full info for owner
        $responseData = [
            'person_name' => $healthCard->person_name,
            'person_photo_url' => $healthCard->person_photo_url ?? null,
            'blood_group' => $healthCard->blood_group,
            'access_type' => $healthCard->access_type,
        ];

        if ($isOwner) {
            $responseData = array_merge($responseData, [
                'id' => $healthCard->id,
                'date_of_birth' => $healthCard->date_of_birth,
                'gender' => $healthCard->gender,
                'card_type' => $healthCard->card_type,
                'emergency_contact' => $healthCard->emergency_contact,
                'allergies' => $healthCard->allergies,
                'qr_code_hash' => $healthCard->qr_code_hash,
                'created_at' => $healthCard->created_at,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $responseData,
        ]);
    }

    /**
     * Get health card by slug or username
     * GET /api/healthcards/public/{slug}
     */
    public function getBySlug($slug): JsonResponse
    {
        $healthCard = HealthCard::where('slug', $slug)
            ->orWhere('username', $slug)
            ->first();

        if (!$healthCard) {
            return response()->json([
                'status' => 'error',
                'message' => 'Health card not found',
            ], 404);
        }

        // Check access permissions
        $isOwner = auth()->check() && auth()->id() === $healthCard->user_id;

        if (!$isOwner && !$healthCard->isAccessible()) {
            return response()->json([
                'status' => 'error',
                'message' => 'This health card is private',
            ], 403);
        }

        // Format photo URL if exists
        if ($healthCard->person_photo) {
            $healthCard->person_photo_url = Storage::url($healthCard->person_photo);
        }

        return response()->json([
            'status' => 'success',
            'data' => $healthCard,
        ]);
    }
}
