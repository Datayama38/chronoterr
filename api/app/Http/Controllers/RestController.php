<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class RestController extends Controller
{
    protected function ok(mixed $data, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $status);
    }

    protected function created(mixed $data): JsonResponse
    {
        return response()->json($data, Response::HTTP_CREATED);
    }

    protected function noContent(): JsonResponse
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    protected function error(
        string $message,
        int $status = Response::HTTP_BAD_REQUEST,
        mixed $errors = null
    ): JsonResponse {
        return response()->json(
            array_filter([
                'message' => $message,
                'errors'  => $errors,
            ]),
            $status
        );
    }
}
