<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';
    protected $fillable = ['id', 'date_admission', 'amount', 'observation', 'status'];

    public function customer() {
        return $this->belongsTo(Customers::class);
    }

    public function percent() {
        return $this->belongsTo(Percent::class);
    }

    public function commission() {
        return $this->belongsTo(Commission::class);
    }

    public function exchangeRate() {
        return $this->belongsTo(ExchangeRate::class);
    }

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function action() {
        return $this->belongsTo(Action::class);
    }
}
