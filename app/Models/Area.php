<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $fillable = ['id', 'name', 'description', 'status'];

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
