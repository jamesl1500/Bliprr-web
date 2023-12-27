<?php
namespace App\Libraries;

use Illuminate\Support\Str;

class Conversation
{
    // Define the models
    protected $conversations_model;
    protected $conversation_members_model;
    protected $conversation_messages_model;

    public function __construct()
    {
        // Load the required models
        $this->conversations_model = new \App\Models\Conversations();
        $this->conversation_members_model = new \App\Models\Conversation_members();
        $this->conversation_messages_model = new \App\Models\Conversation_messages();
    }

    /**
     * GetOtherConversationMember
     */
    public function GetOtherConversationMember($conversation_uid, $user_uid){
        // Get the conversation
        $conversation = $this->conversations_model->where('conversation_uid', $conversation_uid)->first();

        // Get the other member
        $other_member = $this->conversation_members_model->where('conversation_uid', $conversation->id)->where('user_uid', '!=', $user_uid)->first();

        // Return the other member
        return $other_member;
    }

    /**
     * CheckIfUserIsConversationMember
     * 
     * @param string $conversation_uid
     * @param string $user_uid
     */
    public function CheckIfUserIsConversationMember($conversation_uid, $user_uid){
        // Get the conversation
        $conversation = $this->conversations_model->where('conversation_uid', $conversation_uid)->first();

        // Check if the user is a member
        $member = $this->conversation_members_model->where('conversation_uid', $conversation->id)->where('user_uid', $user_uid)->first();

        // Return the member
        return $member;
    }

    /**
     * GetConversationUniqueId
     * 
     * @param string $conversation_id
     */
    public function GetConversationUniqueId($conversation_id){
        // Get the conversation
        $conversation = $this->conversations_model->where('id', $conversation_id)->first();

        // Return the conversation UID
        return $conversation->conversation_uid;
    }

    /**
     * GetConversationMembers
     * 
     * @param string $conversation_uid
     */
    public function GetConversationMembers($conversation_uid){
        $messages = $this->conversations_model->where('conversation_uid', $conversation_uid)->first()->members()->orderBy('created_at', 'asc')->get();

        // Return the messages
        return $messages;
    }

    /**
     * GetConversationMessages
     * 
     * @param string $conversation_uid
     */
    public function GetConversationMessages($conversation_uid){
        $messages = $this->conversations_model->where('conversation_uid', $conversation_uid)->first()->messages()->orderBy('created_at', 'asc')->get();

        // Return the messages
        return $messages;
    }

    /**
     * GenerateUid
     * -----------
     * Generate a unique ID for a conversation, messages, and members.
     * 
     * @return string
     */
    public function GenerateUid(){
        // Generate a unique ID
        $uid = Str::random(35) . time() . Str::random(3);

        // Return the ID
        return $uid;
    }

    /**
     * CheckIfConversationExists
     * -------------------------
     * Check if a conversation exists between two users.
     * 
     * @param string $user_uid_1
     * @param string $user_uid_2
     */
    public function CheckIfConversationExists($user_uid_1, $user_uid_2){
        // Check if a conversation exists between the two users
        return $this->conversations_model->where('conversation_sender', $user_uid_1)->where('conversation_receiver', $user_uid_2)->orWhere('conversation_sender', $user_uid_2)->where('conversation_receiver', $user_uid_1)->first();
    }

    /**
     * CheckIfConversationExistsByUid
     * 
     * @param string $conversation_uid
     */
    public function CheckIfConversationExistsByUid($conversation_uid){
        // Check if a conversation exists between the two users
        return $this->conversations_model->where('conversation_uid', $conversation_uid)->first();
    }

    /**
     * GetLastMessage
     * --------------
     * Get the last message in a conversation.
     * 
     * @param string $conversation_uid
     */
    public function GetLastMessage($conversation_uid){
        // Get the conversation
        $conversation = $this->conversations_model->where('id', $conversation_uid)->first();

        // Get the last message
        $last_message = $conversation->messages()->orderBy('created_at', 'desc')->first();

        // Return the last message
        return $last_message;
    }
}