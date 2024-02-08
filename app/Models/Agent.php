<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';
    protected $fillable = ['id', 'name', 'lastname', 'dni', 'status'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
