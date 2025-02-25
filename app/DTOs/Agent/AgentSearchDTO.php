<?php
namespace App\DTOs\Agent;

use Illuminate\Pagination\LengthAwarePaginator;

class AgentSearchDTO
{

    public $title;
    public $mensaje;
    public $status;
    public $name;

    public function __construct(array $data)
    {
        $data = array_merge([
            'title' => null,
            'mensaje' => null,
            'status' => null,
            'name' => null,
        ], $data);

        $this->title = $data['title'];
        $this->mensaje = $data['mensaje'];
        $this->status = $data['status'];
        $this->name = $data['name'];
    }
}
