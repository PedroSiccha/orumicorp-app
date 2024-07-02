<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';
    protected $fillable = ['id', 'code', 'name', 'lastname', 'phone', 'date_admission', 'status', 'img', 'user_id', 'agent_id', 'optional_phone', 'city', 'country', 'date_admission', 'comment', 'email', 'id_provider', 'id_status'];

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_customers', 'customer_id', 'campaign_id')
                    ->withPivot('status');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_customers', 'customer_id', 'supplier_id')
                    ->withPivot('status');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'id_provider');
    }

    public function status()
    {
        return $this->belongsTo(CustomerStatus::class, 'id_status');
    }

}
