<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    use HasFactory;
    protected $fillable = ['username', 'email', 'password_hash', 'status', 'role', 'brand_id', 'token', 'token_expiry'];
    public $timestamps = true;  // Para mantener los campos created_at y updated_at
    // 🔹 Un API_USER pertenece a un solo BRAND
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    // 🔹 Un API_USER puede haber registrado múltiples CUSTOMERS
    public function customers()
    {
        return $this->hasMany(Customers::class, 'api_user_id');
    }
}
