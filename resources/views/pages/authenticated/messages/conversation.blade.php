<?php
use App\Libraries\Conversation;

$title = "Messages";
$description = "Conversation with ";

// Get conversation
$conversation = new Conversation();

// Get other user
$otherUser = $conversation->GetOtherConversationMember($id, Auth::user()->id);

// Get conversation messages
$messages = $conversation->GetConversationMessages($id);

?>

@extends('layouts.logged')

@section('content')
    <div class="page page-messages">
        <div class="page-head page-messages-head">
            <div class="page-head-inner container-lg container-md container-sm">
                <div class="page-head-left">
                    <h1><?php echo $title; ?></h1>
                    <p><?php echo $description; ?></p>
                </div>
            </div>
        </div>
        <div class="page-content container-lg container-md container-sm">
            <div class="row">
                <div class="page-coversations-left col-lg-3">
                    <div class="conversations-left-head">
                        <div class="conversations-left-head-inner">
                            <div class="conversations-left-head-left">
                                <h2>Conversations</h2>
                            </div>
                        </div>
                    </div>
                    <div class="conversations-left-all">
                        <?php 
                            // Get users conversations
                            $conversations = Auth::user()->conversations()->orderBy('updated_at', 'desc')->get();

                            // Loop through conversations
                            foreach($conversations as $conversation) {
                                // Get other user
                                $otherUser = $conversation->GetOtherConversationMember($conversation->conversation_uid, Auth::user()->id);
                                ?>

                                <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="page-conversations-right col-lg-9">
                    <div class="conversations-right-inner">
                        <div class="conversations-right-head">
                            <div class="conversations-right-head-inner">
                                <div class="conversations-right-head-left">
                                    <?php
                                        // Get name of other user
                                        $user = App\Models\User::find($otherUser->user_uid);
                                    ?>
                                    <h2>Conversation with <?php echo $user->name; ?></h2>
                                </div>
                            </div>
                        </div>
                        <div id="conversations-right-body" class="conversations-right-body">
                            <?php
                                foreach($messages as $message)
                                {
                                    $user = App\Models\User::find($message->user_uid);

                                    // Check if message is from current user
                                    if($message->user_uid == Auth::user()->id)
                                    {
                                        $messageClass = "conversations-right-body-message-me";   
                                    }else{
                                        $messageClass = "conversations-right-body-message-other";
                                    }
                                    ?>
                                        <div class="conversations-right-body-message <?php echo $messageClass; ?>">
                                            <div class="conversations-right-body-message-inner">
                                                <div class="conversations-right-body-message-left">
                                                    <div class="conversations-right-body-message-left-inner">
                                                        <a class="conversations-right-body-message-left-avatar" href="/p/<?php echo $user->username; ?>">
                                                            <img src="/usr_data/<?php echo $user->profile_picture; ?>" alt="<?php echo $user->name; ?>">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="conversations-right-body-message-right">
                                                    <div class="conversations-right-body-message-right-inner">
                                                        <div class="conversations-right-body-message-right-head">
                                                            <div class="conversations-right-body-message-right-head-inner">
                                                                <div class="conversations-right-body-message-right-head-left">
                                                                    <h3><?php echo ucwords($user->name); ?></h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="conversations-right-body-message-right-body">
                                                            <div class="conversations-right-body-message-right-body-inner">
                                                                <p><?php echo $message->conversation_message_content; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="conversations-right-footer">
                            <div class="conversations-right-footer-inner">
                                <div class="conversations-right-footer-left">
                                    <form action="<?php echo route('messages.sendMessage'); ?>" id="message-form" method="POST">
                                        @csrf
                                        <input type="hidden" id="conversation_uid" name="conversation_uid" value="<?php echo $id; ?>">
                                        <textarea name="message" id="message-textarea" placeholder="Type your message here..."></textarea>
                                        <button class="btn btn-primary" type="submit">Send</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection