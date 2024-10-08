<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;
    protected $table = 'transaction_type';
    protected $fillable = ['id', 'name', 'description', 'status'];

    public function deposits() {
        return $this->hasMany(Deposit::class);
    }
}
