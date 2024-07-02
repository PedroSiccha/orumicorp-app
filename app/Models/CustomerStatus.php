<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    use HasFactory;
    protected $table = 'customers_status';
    protected $fillable = [
        'name',
        'color',
        'created_at',
        'updated_at',
    ];

    public function customers()
    {
        return $this->hasMany(Customers::class, 'id_status');
    }
}
