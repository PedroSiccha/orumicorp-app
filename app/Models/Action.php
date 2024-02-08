<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';
    protected $fillable = ['id', 'description', 'observation', 'status'];

    public function movementType() {
        return $this->belongsTo(MovementType::class);
    }

    public function sales() {
        return $this->hasMany(Sales::class);
    }
}
