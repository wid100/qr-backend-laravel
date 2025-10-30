<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HealthCard\Models\HealthCard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'title' => 'required|string|max:191',
            'description' => 'nullable|string',
            'access_type' => ['required', Rule::in(['private', 'protected', 'public'])],
            'meta' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $healthCard = HealthCard::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'qr_code_hash' => HealthCard::generateQrCodeHash(),
                'access_type' => $request->access_type,
                'meta' => $request->meta,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Health card created successfully',
                'data' => [
                    'id' => $healthCard->id,
                    'title' => $healthCard->title,
                    'description' => $healthCard->description,
                    'qr_code_hash' => $healthCard->qr_code_hash,
                    'access_type' => $healthCard->access_type,
                    'meta' => $healthCard->meta,
                    'qr_code_url' => $healthCard->getQrCodeUrlAttribute(),
                    'created_at' => $healthCard->created_at,
                ],
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
        $healthCard = HealthCard::find($id);

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

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $healthCard->id,
                'title' => $healthCard->title,
                'description' => $healthCard->description,
                'qr_code_hash' => $healthCard->qr_code_hash,
                'access_type' => $healthCard->access_type,
                'meta' => $healthCard->meta,
                'qr_code_url' => $healthCard->getQrCodeUrlAttribute(),
                'user_id' => $healthCard->user_id,
                'created_at' => $healthCard->created_at,
                'updated_at' => $healthCard->updated_at,
            ],
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
            'title' => 'sometimes|required|string|max:191',
            'description' => 'nullable|string',
            'access_type' => ['sometimes', 'required', Rule::in(['private', 'protected', 'public'])],
            'meta' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $healthCard->update($request->only(['title', 'description', 'access_type', 'meta']));

            return response()->json([
                'status' => 'success',
                'message' => 'Health card updated successfully',
                'data' => [
                    'id' => $healthCard->id,
                    'title' => $healthCard->title,
                    'description' => $healthCard->description,
                    'qr_code_hash' => $healthCard->qr_code_hash,
                    'access_type' => $healthCard->access_type,
                    'meta' => $healthCard->meta,
                    'qr_code_url' => $healthCard->getQrCodeUrlAttribute(),
                    'updated_at' => $healthCard->updated_at,
                ],
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

        // Return basic info for public/protected cards, full info for owner
        $responseData = [
            'title' => $healthCard->title,
            'description' => $healthCard->description,
            'access_type' => $healthCard->access_type,
        ];

        if ($isOwner) {
            $responseData = array_merge($responseData, [
                'id' => $healthCard->id,
                'qr_code_hash' => $healthCard->qr_code_hash,
                'meta' => $healthCard->meta,
                'created_at' => $healthCard->created_at,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $responseData,
        ]);
    }
}
