<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traiding extends Model
{
    use HasFactory;
    protected $table = 'traiding';
    protected $fillable = ['id', 'code', 'description', 'status'];

    public function customers() {
        return $this->hasMany(Customers::class);
    }
}
