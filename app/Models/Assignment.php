<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';
    protected $fillable = [
        'agent_id',
        'customer_id',
        'date',
        'assignated_by_id',
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

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assignated_by_id');
    }
}
