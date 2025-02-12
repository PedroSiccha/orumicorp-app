<?php

namespace App\Imports;

use App\Models\Agent;
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
use Illuminate\Validation\ValidationException;

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

        if (empty($row['correo'])) {
            throw ValidationException::withMessages(['correo' => 'El correo no puede ser vacío.']);
        }
        if (empty($row['telefono'])) {
            throw ValidationException::withMessages(['telefono' => 'El teléfono no puede ser vacío.']);
        }

        if (Customers::where('email', $row['correo'])->exists()) {
            throw ValidationException::withMessages(['correo' => "El correo {$row['correo']} ya existe."]);
        }

        if (Customers::where('phone', $row['telefono'])->exists()) {
            throw ValidationException::withMessages(['telefono' => "El teléfono {$row['telefono']} ya existe."]);
        }

        $agent = Agent::where('user_id', $user->id)->first();

        if (!$agent) {
            throw ValidationException::withMessages(['agente' => "No se encontró un agente asociado al usuario."]);
        }

        $providerId = $this->providers[strtolower(trim($row['provedor']))] ?? null;
        $statusId = $this->status[strtolower(trim($row['estado']))] ?? $this->status['NEW'];

        return new Customers([
            'code' => $code,
            'name' => $row['nombres'],
            'lastname' => $row['apellidos'],
            'user_id' => $user->id,
            'agent_id' => $agent->id,
            'phone' => $row['telefono'],
            'date_admission' => date('Y-m-d'),
            'status' => true,
            'optional_phone' => $row['telefono_opcional'],
            'city' => $row['ciudad'],
            'country' => $row['pais'],
            'comment' => $row['comentarios'],
            'email' => $row['correo'],
            'id_provider' => $providerId,
            'id_status' => $statusId,
        ]);
    }

    public function batchSize(): int {
        return 5000;
    }

    public function chunkSize(): int {
        return 5000;
    }

}
