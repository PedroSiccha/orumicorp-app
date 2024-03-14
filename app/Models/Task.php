<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'document', 'timeStart', 'timeEnd', 'date', 'agent_id'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

}
