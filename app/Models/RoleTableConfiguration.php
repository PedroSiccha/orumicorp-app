<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleTableConfiguration extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'table_name', 'visible_columns'];

    protected $casts = [
        'visible_columns' => 'array' // Laravel convierte JSON a array automáticamente
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
