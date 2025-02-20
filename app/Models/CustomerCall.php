<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCall extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'call_status_id', 'call_date'
    ];
    public $timestamps = true;
    // Relación con la tabla customers
    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
    // Relación con la tabla call_statuses
    public function callStatus()
    {
        return $this->belongsTo(CallStatus::class);
    }
}
