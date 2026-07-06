<?php

namespace App\Modules\HealthCard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HealthCard\Models\HealthCard;
use App\Modules\HealthCard\Models\HealthCardCondition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HealthCardConditionController extends Controller
{
    public function index($healthCardId): JsonResponse
    {
        $healthCard = $this->findOwnedCard($healthCardId);
        if (!$healthCard) {
            return $this->errorResponse('Health card not found', 404);
        }

        $conditions = HealthCardCondition::where('health_card_id', $healthCard->id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $conditions,
        ]);
    }

    public function store(Request $request, $healthCardId): JsonResponse
    {
        $healthCard = $this->findOwnedCard($healthCardId);
        if (!$healthCard) {
            return $this->errorResponse('Health card not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $condition = HealthCardCondition::create([
            'health_card_id' => $healthCard->id,
            'name' => $request->name,
            'description' => $request->description,
            'sort_order' => $request->input('sort_order', 0),
            'is_emergency_enabled' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Condition created successfully',
            'data' => $condition,
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $condition = $this->findOwnedCondition($id);
        if (!$condition) {
            return $this->errorResponse('Condition not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:191',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $condition->update($request->only(['name', 'description', 'sort_order']));

        return response()->json([
            'status' => 'success',
            'message' => 'Condition updated successfully',
            'data' => $condition->fresh(),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $condition = $this->findOwnedCondition($id);
        if (!$condition) {
            return $this->errorResponse('Condition not found', 404);
        }

        $condition->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Condition deleted successfully',
        ]);
    }

    public function enableEmergency($id): JsonResponse
    {
        $condition = $this->findOwnedCondition($id);
        if (!$condition) {
            return $this->errorResponse('Condition not found', 404);
        }

        HealthCardCondition::where('health_card_id', $condition->health_card_id)
            ->where('id', '!=', $condition->id)
            ->update(['is_emergency_enabled' => false]);

        $condition->update(['is_emergency_enabled' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Emergency access enabled for this condition',
            'data' => $condition->fresh(),
        ]);
    }

    public function disableEmergency($id): JsonResponse
    {
        $condition = $this->findOwnedCondition($id);
        if (!$condition) {
            return $this->errorResponse('Condition not found', 404);
        }

        $condition->update(['is_emergency_enabled' => false]);

        return response()->json([
            'status' => 'success',
            'message' => 'Emergency access disabled for this condition',
            'data' => $condition->fresh(),
        ]);
    }

    private function findOwnedCard($healthCardId): ?HealthCard
    {
        return HealthCard::where('id', $healthCardId)
            ->where('user_id', Auth::id())
            ->first();
    }

    private function findOwnedCondition($id): ?HealthCardCondition
    {
        return HealthCardCondition::where('id', $id)
            ->whereHas('healthCard', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->first();
    }

    private function errorResponse(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }
}
