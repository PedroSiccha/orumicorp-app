<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationOnUpdateModel extends Model
{
    use HasFactory;
    protected $table = 'notification_update';
    protected $fillable = ['user_id', 'module', 'is_seen'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
