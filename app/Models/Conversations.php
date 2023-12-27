<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversations extends Model
{
    use HasFactory;

    // Define fillable fields
    protected $fillable = ['conversation_uid', 'conversation_sender', 'conversation_receiver', 'conversation_name', 'conversation_description'];

    /**
     * Get the messages that belong to the conversation.
     */
    public function messages()
    {
        return $this->hasMany(Conversation_messages::class, 'conversation_uid');
    }

    /**
     * Get the members that belong to the conversation.
     */
    public function members()
    {
        return $this->hasMany(Conversation_members::class, 'conversation_uid');
    }
}
