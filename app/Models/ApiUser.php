<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'username', 'password_hash', 'token', 'token_expiry'
    ];
    public $timestamps = true;  // Para mantener los campos created_at y updated_at
}
