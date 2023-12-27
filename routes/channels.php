<?php

use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\ConversationChannel;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversation_uid}', function ($user, $conversation_uid) {
    return new ConversationChannel($conversation_uid);
});