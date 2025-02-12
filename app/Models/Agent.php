<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agents';
    protected $fillable = ['id', 'code', 'name', 'lastname', 'code_voiso', 'status', 'number_turns', 'img'. 'status_voiso'];

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

    public function views() {
        return $this->hasMany(Views::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}
