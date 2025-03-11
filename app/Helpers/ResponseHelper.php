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

    private static function prepareData($data)
    {
        foreach ($data as $key => $value) {
            if ($value instanceof \Illuminate\Pagination\LengthAwarePaginator) {
                // ✅ Convertimos a JSON pero mantenemos el objeto
                $data[$key] = $value->toArray();
            } elseif ($value instanceof \Illuminate\Database\Eloquent\Collection) {
                // ✅ Para colecciones, convertimos en un JSON serializable
                $data[$key] = $value->toJson();
            }
        }
        return json_decode(json_encode($data)); // 🔹 Evita que Laravel convierta a array
    }
}
