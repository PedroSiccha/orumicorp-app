<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    use HasFactory;
    protected $table = 'views';
    protected $fillable = ['agent_id', 'customer_id', 'viewed_at'];

    public $timestamp = false;

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function customer() {
        return $this->belongsTo(Customers::class);
    }

}
