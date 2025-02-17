<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'token', 'token_expiry'
    ];
    public $timestamps = true;
    // Relación con la tabla customers
    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
}
