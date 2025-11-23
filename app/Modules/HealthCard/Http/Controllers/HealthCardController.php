<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HealthCard\Models\HealthCard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
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
                $photoPath = $photo->store('health-cards/photos', 'public');
            }

            // Generate slug from person name
            $slug = HealthCard::generateSlug($request->person_name);

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
            ]);

            // Load relationship
            $healthCard->load('user');

            return response()->json([
                'status' => 'success',
                'message' => 'Health card created successfully',
                'data' => $healthCard,
            ], 201);
        } catch (\Exception $e) {
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

        $validator = Validator::make($request->all(), [
            'person_name' => 'sometimes|required|string|max:255',
            'person_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'gender' => 'nullable|in:male,female,other',
            'card_type' => 'sometimes|in:pregnant,child,adult,senior',
            'expected_delivery_date' => 'nullable|date',
            'emergency_contact' => 'nullable|string',
            'allergies' => 'nullable|string',
            'username' => 'nullable|string|max:255|unique:health_cards,username,' . $id,
            'access_type' => ['sometimes', Rule::in(['private', 'protected', 'public'])],
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
                'person_name', 'date_of_birth', 'blood_group', 'gender',
                'card_type', 'expected_delivery_date', 'emergency_contact',
                'allergies', 'username', 'access_type'
            ]);

            // Handle photo upload
            if ($request->hasFile('person_photo')) {
                // Delete old photo if exists
                if ($healthCard->person_photo) {
                    Storage::disk('public')->delete($healthCard->person_photo);
                }
                $photo = $request->file('person_photo');
                $data['person_photo'] = $photo->store('health-cards/photos', 'public');
            }

            // Update slug if person_name changed
            if ($request->has('person_name') && $request->person_name !== $healthCard->person_name) {
                $data['slug'] = HealthCard::generateSlug($request->person_name);
            }

            $healthCard->update($data);
            $healthCard->refresh();

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
