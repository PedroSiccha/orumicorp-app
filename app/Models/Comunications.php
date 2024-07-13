<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunications extends Model
{
    use HasFactory;

    protected $table = 'comunications';

    protected $fillable = [
        'agent_id',
        'customer_id',
        'date',
        'tipo',
        'descripcion',
        'comment',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }


}
