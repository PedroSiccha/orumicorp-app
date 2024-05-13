<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = ['name', 'lastname', 'phone', 'email', 'status', 'observation'];

    public function customers()
    {
        return $this->belongsToMany(Customers::class, 'supplier_customers', 'supplier_id', 'customer_id')
                    ->withPivot('status');
    }
}
