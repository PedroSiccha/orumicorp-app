<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageWhatsappModel extends Model
{
    use HasFactory;
    protected $table = 'messages_whatsapp';
    protected $fillable = ['agent_id', 'customer_id', 'content', 'status'];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}
