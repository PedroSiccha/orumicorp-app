<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($message = 'Operación exitosa', $data = [], $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function error($message = 'Ha ocurrido un error', $errors = [], $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
