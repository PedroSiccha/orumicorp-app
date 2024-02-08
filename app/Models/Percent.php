<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percent extends Model
{
    protected $table = 'percents';

    protected $fillable = ['id', 'percent', 'description', 'status'];

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
}
