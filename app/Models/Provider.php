<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $table = 'providers';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'created_at',
        'updated_at',
    ];
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'id_proveedor');
    }

    public function customers()
    {
        return $this->hasMany(Customers::class, 'id_provider');
    }
}
