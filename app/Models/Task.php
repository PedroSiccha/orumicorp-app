<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'task_local';
    protected $fillable = ['name', 'description', 'document', 'timeStart', 'timeEnd', 'date', 'agent_id', 'priority_id', 'customer_id', 'start', 'end'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

}
