<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'id', 
        'code', 
        'name', 
        'lastname', 
        'phone', 
        'date_admission', 
        'status', 
        'img', 
        'user_id', 
        'agent_id', 
        'optional_phone', 
        'city', 
        'country', 
        'brand_id',
        'is_lead',
        'last_login',
        'last_deposit_date', 
        'comment', 
        'email', 
        'id_provider', 
        'id_status', 
        'platform_id', 
        'traiding_id', 
        'folder_id', 
        'uuid', 
        'call_black', 
        'callbell_uuid', 
        'call_init', 
        'closed_at', 
        'callbell_uuid', 
        'callbel_source', 
        'callbell_href', 
        'callbell_conversationHref', 
        'callbel_tags', 
        'callbel_custom_fields', 
        'callbel_team', 
        'callbel_channel', 
        'callbel_blocked_at'
    ];

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

    public function comunications()
    {
        return $this->hasMany(Comunications::class, 'customer_id');
    }

    public function assignaments()
    {
        return $this->hasMany(Assignment::class, 'customer_id');
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaing::class, 'campaign_customers');
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

    public function statusCustomer()
    {
        return $this->belongsTo(CustomerStatus::class, 'id_status');
    }

    public function platform() {
        return $this->belongsTo(Platform::class);
    }

    public function folder() {
        return $this->belongsTo(Folder::class);
    }

    public function traiding() {
        return $this->belongsTo(Traiding::class);
    }

    public function views() {
        return $this->hasMany(Views::class);
    }

    public function latestCampaign()
    {
        $lastCampaign = $this->belongsToMany(Campaing::class, 'campaign_customers', 'customer_id', 'campaing_id')
                            ->withPivot('status')
                            ->latest('campaign_customers.created_at')
                            ->take(1);

        if ($lastCampaign == null) {
            $lastCampaign = null;
        }

        return $lastCampaign;
    }

    public function latestSupplier()
    {
        return $this->belongsToMany(Supplier::class, 'supplier_customers', 'customer_id', 'supplier_id')->withPivot('status')->latest('supplier_customers.created_at')->take(1);
    }

    public function latestComunication()
    {
        return $this->hasOne(Comunications::class, 'customer_id')->where('status', 1)->latest('date')->take(1);
    }

    public function latestAssignamet()
    {
        return $this->hasOne(Assignment::class, 'customer_id')->where('status', 1)->with(['agent'])->latest('date');
    }

    public function latestAssignametBy()
    {
        return $this->hasOne(Assignment::class, 'customer_id')->with(['assignedBy'])->latest('date');
    }

    public function latestDeposit()
    {
        return $this->hasOne(Deposit::class, 'customer_id')->with(['agent', 'transactionType'])->latest('date')->take(1);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'customer_id');
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function tradingAccounts()
    {
        return $this->hasMany(TradingAccount::class, 'customer_id');
    }

    public function customerToken()
    {
        return $this->hasOne(CustomerToken::class, 'customer_id');
    }

    public function customerCalls()
    {
        return $this->hasMany(CustomerCall::class, 'customer_id');
    }

    public function callStatus()
    {
        return $this->hasManyThrough(CallStatus::class, CustomerCall::class, 'customer_id', 'id', 'id', 'call_status_id');
    }

}
