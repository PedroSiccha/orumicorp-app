<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    protected $table = 'premios';
    protected $fillable = ['id', 'name', 'description', 'value', 'status', 'type', 'order', 'active'];
}
