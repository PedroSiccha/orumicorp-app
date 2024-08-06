<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;
    protected $table = 'deposit';
    protected $fillable = [
        'agent_id',
        'customer_id',
        'date',
        'number',
        'tipo',
        'descripcion',
        'amount',
        'transaction_type_id',
        'users_id'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function transactionType() {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }
}
