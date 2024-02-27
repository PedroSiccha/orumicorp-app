<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowedIP extends Model
{
    protected $table = 'allowedip';
    protected $fillable = ['id', 'user_id', 'name', 'description', 'ip', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
