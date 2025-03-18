<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTableConfiguration extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'table_name', 'visible_columns'];

    protected $casts = [
        'visible_columns' => 'array' // Laravel convierte JSON a array automáticamente
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
