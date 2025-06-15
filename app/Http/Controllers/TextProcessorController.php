<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\TextProcessRequest;
use App\Services\TextProcessorService;

class TextProcessorController extends Controller
{
    protected $textProcessorService;

    public function construct(TextProcessorService $textProcessorService)
    {
        $this->textProcessorService = $textProcessorService;
    }

    public function process(TextProcessRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            
            $result = $this->textProcessorService->processText(
                $validated['text'],
                $validated['operations']
            );

            return response()->json([
                'original_text' => $validated['text'],
                'processed_text' => $result,
                'operations' => $validated['operations']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => '處理文字時發生錯誤',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}