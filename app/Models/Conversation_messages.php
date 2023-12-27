<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation_messages extends Model
{
    use HasFactory;

    // Define fillable fields
    protected $fillable = ['conversation_message_uid', 'conversation_uid', 'user_uid', 'conversation_message_content', 'conversation_message_type', 'conversation_message_status'];

    /**
     * Get the conversation that owns the message.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversations::class, 'conversation_uid');
    }

    /**
     * Get the user that owns the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uid');
    }
}
