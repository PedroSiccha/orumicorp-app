<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permission';

    protected $fillable = [
        'name',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'roles_permisions', 'permision_id', 'rol_id');
    }
}
