<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public static function success($data, $message = null, $status = 200)
    {
        return response()->json([
            'message' => $message ?? 'Success',
            'data' => $data
        ], $status);
    }

    public static function error($data = null, $message = 'Something went wrong', $statusCode = 500)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public static function validation($errors)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $errors
        ], 422);
    }
}
