<?php

namespace App\Imports;

use App\Models\Customers;
use App\Models\CustomerStatus;
use App\Models\Platform;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $providers;
    private $status;
    private $platform;
    public function __construct()
    {
        $this->providers = Provider::pluck('id', 'name');
        $this->status = CustomerStatus::pluck('id', 'name');
        $this->platform = Platform::pluck('id', 'name');
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = Auth::user();
        $getInitials = function($name) {
            $words = explode(' ', trim($name));
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            return $initials;
        };

        $code = !empty($row['codigo']) ? $row['codigo'] : $getInitials($row['nombres']) . $getInitials($row['apellidos']) . '_' . $user->id;

        return new Customers([
            'code' => $code,
            'name' => $row['nombres'],
            'lastname' => $row['apellidos'],
            'user_id' => $user->id,
            'agent_id' => $user->id,
            'phone' => $row['telefono'],
            'date_admission' => date('Y-m-d'),
            'status' => true,
            'optional_phone' => $row['telefono_opcional'],
            'city' => $row['ciudad'],
            'country' => $row['pais'],
            'comment' => $row['comentarios'],
            'email' => $row['correo'],
            'id_provider' => $this->providers[trim($row['provedor'])],
            'id_status' => $this->status[!empty(trim($row['estado'])) ? trim($row['estado']) : 'NEW'],
            // 'platform_id' => $this->platform[trim($row['plataforma'])]
        ]);
    }

    public function batchSize(): int {
        return 5000;
    }

    public function chunkSize(): int {
        return 5000;
    }

}
