<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($message = 'Operación exitosa', $data = [], int $status = 200)
    {
        // dd($data);
        return response()->json([
            'title' => 'Operación exitosa',
            'status' => 'success',
            'success' => true,
            'message' => $message,
            'data' => $data, // ✅ Usamos un método para formatear correctamente
        ], $status, [], JSON_UNESCAPED_UNICODE);
    }

    public static function error($message = 'Ha ocurrido un error', $errors = [], $status = 400)
    {
        return response()->json([
            'title' => 'Error',
            'status' => 'error',
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
