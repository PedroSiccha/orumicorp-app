<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shooter extends Model
{
    use HasFactory;
    protected $table = 'shooter';
    protected $fillable = ['name', 'status', 'start', 'end', 'folder_id'];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

}
