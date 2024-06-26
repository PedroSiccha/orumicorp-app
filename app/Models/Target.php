<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'targets';
    protected $fillable = ['id', 'amount', 'month', 'observation', 'status'];

    public function agent() {
        return $this->belongsTo(Agent::class);
    }
}
