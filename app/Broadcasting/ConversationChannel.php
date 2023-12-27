<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Libraries\Conversation;
use Illuminate\Support\Facades\Log;

class ConversationChannel
{
    public $conversation_uid;

    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct($conversation_uid)
    {
        //
        $this->conversation_uid = $conversation_uid;

        Log::info("New user joined conversation with UID: $conversation_uid");

    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user)
    {
        // Check if the user is a member of the conversation
        $conversation = new Conversation();

        // Check if the user is a member of the conversation
        $member = $conversation->CheckIfUserIsConversationMember($this->conversation_uid, $user->id);

        // If they are not a member, return false
        if (!$member) {
            return false;
        }

        return true;
    }

}
