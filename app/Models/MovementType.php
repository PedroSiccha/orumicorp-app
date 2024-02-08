<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    protected $table = 'movement_types';
    protected $fillable = ['id', 'name', 'description', 'status'];

    public function action()
    {
        return $this->hasMany(Action::class);
    }
}
