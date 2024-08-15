<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $table = 'folder';
    protected $fillable = ['name', 'status', 'category_id'];

    public function shooters()
    {
        return $this->hasMany(Shooter::class, 'folder_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryFolder::class, 'category_id');
    }

    public function clients()
    {
        return $this->hasMany(Customers::class, 'folder_id');
    }

}
