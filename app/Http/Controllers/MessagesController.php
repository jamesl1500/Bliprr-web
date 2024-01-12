<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Conversation;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    // Conversation library
    protected $conversation;

    public function __construct()
    {
        $this->conversation = new Conversation();
    }

    // Index page
    public function index()
    {
        return view('pages.authenticated.messages.index', ['conversation_m' => $this->conversation]);
    }

    // Conversation view page
    public function conversation($id)
    {
        // Check if the conversation exists
        $conversation = $this->conversation->CheckIfConversationExistsByUid($id);

        if (!$conversation) {
            return redirect('/messages')->with('error', 'Conversation does not exist.');
        }

        return view('pages.authenticated.messages.conversation', ['id' => $id, 'conversation_m' => $this->conversation]);
    }

    // Create conversation view
    public function createConversation($user_id)
    {
        // Check if they have a conversation already
        $conversation = $this->conversation->CheckIfConversationExists(Auth::user()->id, $user_id);

        // If they do, redirect them to the conversation
        if ($conversation) {
            return redirect('/messages/conversation/' . $conversation->conversation_uid);
        }

        // Get user data
        $user = \App\Models\User::where('id', $user_id)->first();

        return view('pages.authenticated.messages.create_conversation', ['user' => $user]);
    }

    // Create conversation (Post)
    public function createConversationPost(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required',
            'message' => 'required'
        ]);

        // Check if user exists
        $user = \App\Models\User::where('id', $request->input('user_id'))->first();

        if (!$user) {
            return redirect('/messages')->with('error', 'User does not exist.');
        }

        // Check if they have a conversation already
        $conversation = $this->conversation->CheckIfConversationExists(Auth::user()->id, $request->input('user_id'));

        // If they do, redirect them to the conversation
        if ($conversation) {
            return redirect('/messages/conversation/' . $conversation->conversation_uid);
        }

        // Create the conversation
        $conversation = \App\Models\Conversations::create([
            'conversation_uid' => $this->conversation->GenerateUid(),
            'conversation_sender' => Auth::user()->id,
            'conversation_receiver' => $request->input('user_id'),
            'conversation_name' => '',
            'conversation_description' => 'Conversation between ' . Auth::user()->name . ' and ' . \App\Models\User::where('id', $request->input('user_id'))->first()->name
        ]);

        // Create the conversation message
        $conversation_message = \App\Models\Conversation_messages::create([
            'conversation_message_uid' => $this->conversation->GenerateUid(),
            'conversation_uid' => $conversation->id,
            'user_uid' => Auth::user()->id,
            'conversation_message_content' => $request->input('message'),
            'conversation_message_type' => 'text',
            'conversation_message_status' => 'unread'
        ]);

        // Create the conversation member for the sender
        $conversation_member_sender = \App\Models\Conversation_members::create([
            'conversation_member_uid' => $this->conversation->GenerateUid(),
            'conversation_uid' => $conversation->id,
            'user_uid' => Auth::user()->id,
            'user_role' => 'admin'
        ]);

        // Create the conversation member for the receiver
        $conversation_member_receiver = \App\Models\Conversation_members::create([
            'conversation_member_uid' => $this->conversation->GenerateUid(),
            'conversation_uid' => $conversation->id,
            'user_uid' => $request->input('user_id'),
            'user_role' => 'member'
        ]);

        // Redirect the user to the conversation
        return redirect("/messages/" . $conversation->conversation_uid);
    }

    // Send message (Post)
    public function sendMessagePost(Request $request)
    {
        // Validate the request
        $request->validate([
            'conversation_uid' => 'required',
            'message' => 'required'
        ]);

        // Check if the conversation exists
        $conversation = $this->conversation->CheckIfConversationExistsByUid($request->input('conversation_uid'));

        if (!$conversation) {
            return redirect('/messages')->with('error', 'Conversation does not exist.');
        }

        // Check if the user is a member of the conversation
        $conversation_member = $this->conversation->CheckIfUserIsConversationMember($request->input('conversation_uid'), Auth::user()->id);

        if (!$conversation_member) {
            return redirect('/messages')->with('error', 'You are not a member of this conversation.');
        }

        // Create the conversation message
        $conversation_message = \App\Models\Conversation_messages::create([
            'conversation_message_uid' => $this->conversation->GenerateUid(),
            'conversation_uid' => $conversation->id,
            'user_uid' => Auth::user()->id,
            'conversation_message_content' => $request->input('message'),
            'conversation_message_type' => 'text',
            'conversation_message_status' => 'unread'
        ]);

        // Return the message
        $conversation_message['author'] = array(
            'name' => Auth::user()->name,
            'username' => Auth::user()->username,
            'avatar' => Auth::user()->profile_picture
        );

        // Send event
        event(new \App\Events\MessagePosted($conversation_message));

        // Return json response
        return response()->json($conversation_message);
    }

}
