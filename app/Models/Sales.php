<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $fillable = ['id', 'date_admission', 'amount', 'percent', 'exchange_rate', 'commission', 'observation', 'status'];

    public function customer() {
        return $this->belongsTo(Customers::class);
    }

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function action() {
        return $this->belongsTo(Action::class);
    }
}
