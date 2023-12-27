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
            <div class="page-coversations-left">
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
                            
                        }
                    ?>
                </div>
            </div>
            <div class="page-conversations-right">
                <div class="conversations-right-inner">

                </div>
            </div>
        </div>
    </div>
@endsection