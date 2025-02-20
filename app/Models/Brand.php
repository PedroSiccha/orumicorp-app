<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'site_url'
    ];
    public $timestamps = true;
    // 🔹 Un BRAND tiene muchos API_USERS
    public function apiUsers()
    {
        return $this->hasMany(ApiUser::class, 'brand_id');
    }
    // 🔹 Un BRAND tiene muchos CUSTOMERS
    public function customers()
    {
        return $this->hasMany(Customers::class, 'brand_id');
    }
}
