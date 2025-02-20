<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'currency_id', 'is_demo', 'platform_id', 'trading_account_group_id'
    ];
    public $timestamps = true;
    // Relación con la tabla customers
    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }
    // Relación con la tabla currencies
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    // Relación con la tabla platforms
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    // Relación: Un TradingAccount puede pertenecer a un grupo de cuentas de trading
    public function tradingAccountGroup()
    {
        return $this->belongsTo(TradingAccountGroup::class, 'trading_account_group_id');
    }
}
