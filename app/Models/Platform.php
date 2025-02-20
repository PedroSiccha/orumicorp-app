<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $table = 'platforms';
    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'marketing_info',
        'created_at',
        'updated_at',
    ];

    public function customers() {
        return $this->hasMany(Customers::class);
    }
}
