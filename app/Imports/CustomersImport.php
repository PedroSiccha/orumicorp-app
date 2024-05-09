<?php

namespace App\Imports;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $user_id = null;

        $user = User::firstOrCreate(['email' => $row['correo']], [
            'name' => $row['nombres'],
            'email' => $row['correo'],
            'password' => Hash::make($row['codigo']),
        ]);

        return new Customers([
            'code' => $row['codigo'],
            'name' => $row['nombres'],
            'lastname' => $row['apellidos'],
            'user_id' => $user_id,
            'phone' => $row['telefono'],
            'date_admission' => date('Y-m-d'),
            'status' => true,
            'optional_phone' => $row['telefono_opcional'],
            'city' => $row['ciudad'],
            'country' => $row['pais'],
            //'campaign' => 1,
            //'supplier' => 1,
            'comment' => $row['comentarios'],
        ]);
    }

    public function batchSize(): int {
        return 5000;
    }

    public function chunkSize(): int {
        return 5000;
    }

}
