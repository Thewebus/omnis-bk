<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function messageable() {
        return $this->morphTo(__FUNCTION__, 'chat_messageable_type', 'chat_messageable_id');
    }
}
