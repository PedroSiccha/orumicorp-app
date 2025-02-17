<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingAccountGroup extends Model
{
    use HasFactory;
    protected $table = 'trading_account_groups';
    protected $fillable = [
        'name',
        'description'
    ];
    public $timestamps = true;
    // Relación: Un grupo de cuentas de trading puede tener muchas cuentas de trading
    public function tradingAccounts()
    {
        return $this->hasMany(TradingAccount::class, 'trading_account_group_id');
    }
}
