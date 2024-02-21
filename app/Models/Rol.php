<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'rol_id', 'user_id');
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'roles_permisions', 'rol_id', 'permision_id');
    }
}
