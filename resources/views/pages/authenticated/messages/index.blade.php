<?php
$title = "Messages";
$description = "View your messages.";
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
                        <ul>
                        <?php 
                            // Get users conversations
                            $conversations = Auth::user()->conversations()->orderBy('updated_at', 'desc')->get();

                            // Loop through conversations
                            foreach($conversations as $conversation) {
                                // Get other user
                                $otherUser = $conversation_m->GetOtherConversationMember($conversation->conversation_uid, Auth::user()->id);

                                // Get user info
                                $otherUserInfo = App\Models\User::find($otherUser->user_uid);

                                // Get last conversation message
                                $lastMessage = $conversation_m->GetLastMessage($conversation->conversation_uid);

                                // Get conversation unique id
                                $uid = $conversation_m->GetConversationUniqueId($conversation->conversation_uid);
                                ?>
                                    <li class="conversation-list-item">
                                        <div class="conversations-left-all-inner">
                                            <div class="conversations-left-all-left">
                                                <div class="conversations-left-all-left-inner">
                                                    <a href="/p/<?php echo $otherUserInfo->username; ?>">
                                                        <img src="/usr_data/<?php echo $otherUserInfo->profile_picture; ?>" alt="<?php echo $otherUserInfo->name; ?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="conversations-left-all-right">
                                                <a href="{{ route('messages.conversation', $uid) }}">
                                                    <h3><?php echo $otherUserInfo->name; ?></h3>
                                                    <p><?php echo $lastMessage->conversation_message_content; ?></p>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php
                            }
                        ?>
                        </ul>
                    </div>
                </div>
                <div class="page-conversations-right col-lg-9">
                    <div class="conversations-right-inner">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection