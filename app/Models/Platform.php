<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $table = 'platforms';
    protected $fillable = ['id', 'name', 'description', 'status'];

    public function customers() {
        return $this->hasMany(Customers::class);
    }
}
