<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FaqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * TASK-08: FAQ / self-service help API endpoint
 * Owner: Thando
 * DoD: GET /api/faqs returns 200 with active FAQs (optionally filtered
 *      by category/search), GET /api/faqs/{id} returns 200 for a valid
 *      id, 404 for unknown id, 422 for malformed input.
 */
class FaqController extends Controller
{
    public function __construct(private FaqService $faqs)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category' => ['nullable', 'string', 'max:50'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid query parameters.',
            ], 422);
        }

        try {
            $result = $this->faqs->getFaqs(
                category: $request->query('category'),
                search: $request->query('search'),
            );
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => 'A system error occurred. Please try again shortly.',
            ], 500);
        }

        return response()->json(['success' => true, 'data' => $result]);
    }

    public function show(string $id): JsonResponse
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => ['required', 'integer', 'min:1']]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid FAQ id format.',
            ], 422);
        }

        try {
            $result = $this->faqs->getFaqById((int) $id);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => 'A system error occurred. Please try again shortly.',
            ], 500);
        }

        if (! $result) {
            return response()->json([
                'success' => false,
                'error' => 'No FAQ found with that id.',
            ], 404);
        }

        return response()->json(['success' => true, 'data' => $result]);
    }
}