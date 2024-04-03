<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    protected $table = 'assistance';
    protected $fillable = ['id', 'hour', 'date', 'date_end', 'type', 'observation'];

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

}
