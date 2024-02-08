<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table = 'commissions';
    protected $fillable = ['id', 'name', 'amount', 'status'];

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
}
