<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;
    protected $table = 'config_local';
    protected $fillable = [
        'user_id', 'name', 'view', 'status',
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
