<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFolder extends Model
{
    use HasFactory;
    protected $table = 'category_folder';
    protected $fillable = ['name', 'status'];

    public function folders()
    {
        return $this->hasMany(Folder::class, 'category_id');
    }
}
