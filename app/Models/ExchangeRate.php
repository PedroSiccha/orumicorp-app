<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $table = 'exchange_rates';
    protected $fillable = ['id', 'name', 'amount', 'status'];

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
}
