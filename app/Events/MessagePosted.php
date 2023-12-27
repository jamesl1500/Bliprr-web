<?php

namespace App\Events;

use App\Models\Conversation_messages;
use GuzzleHttp\Psr7\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use \App\Libraries\Conversation;

class MessagePosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    protected $conversation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conversation_messages $message)
    {
        //
        $this->conversation = new Conversation();
        
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Return the channel uid
        $uid = $this->conversation->GetConversationUniqueId($this->message->conversation_uid);
        return new PrivateChannel('conversation.' . $uid);
    }
}
