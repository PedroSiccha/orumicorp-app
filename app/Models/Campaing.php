<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaing extends Model
{
    use HasFactory;
    protected $table = 'campaigns';
    protected $fillable = ['name', 'description', 'start_date', 'end_date'];

    public function customers()
    {
        // return $this->belongsToMany(Customers::class, 'campaign_customers', 'campaign_id', 'customer_id')
        //             ->withPivot('status');
        return $this->belongsToMany(Customers::class, 'campaign_customers');
    }

}
