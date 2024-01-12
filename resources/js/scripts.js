import Echo from "laravel-echo"

jQuery(function(){
    /**
     * Close alert
     */
    $('.close').click(function(){
        $('.alert').fadeOut('slow');
    });
});

var busy = false;

/**
 * Logout function
 */
const logout = (e) => {
    e.preventDefault();
    document.getElementById('logoutForm').submit();
}
document.getElementById('logoutBtnAction').addEventListener('click', logout);

// Blip ajax functions

/**
 * Delete Blip function
 * @param {int} id 
 */
const deleteBlip = (id) => {
    $.ajax({
        url: '/api/blip/delete',
        type: 'DELETE',
        data: {
            blip_id: id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result){
            if(result.status == 'success' && result){
                $('#blip-' + id).fadeOut('slow');
            }
        },
        error: function(result){
            alert(result.message);
        }
    });
}

document.querySelectorAll('.delete').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        deleteBlip(item.dataset.id);
    })
});

/**
 * Reply Blip function
 */
const replyBlip = (e) => {
    if(busy) return false;
    busy = true;
    e.preventDefault();
    const blipId = e.target.dataset.bid;
    const blipContent = document.getElementById('blip-reply-textarea-' + blipId).value;

    if(blipContent == ''){
        alert('Please enter a reply');
        return false;
    }

    if(blipId == ''){
        alert('Invalid blip reply');
        return false;
    }

    $.ajax({
        url: '/blip/reply',
        type: 'POST',
        data: {
            blip_id: blipId,
            blip_content: blipContent,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result){
            if(result.status == 'success' && result){
                $('#blip-reply-form-' + blipId).fadeOut('slow');

                const profile_picture = result.reply_author_avatar;
                const username = result.reply_author_username;
                const name = result.reply_author_name;

                const content = result.reply_content;

                // Append reply to blip
                $('#blip-replies-holder-' + blipId).prepend(
                    '<div class="blip-reply-item" id="blip-reply-' + blipId + '">' +
                        '<div class="inner-blip-reply-item">' +
                            '<div class="profile_image" style="background-image: url(/usr_data/'+profile_picture+');"></div>' +
                            '<div class="right_information">' +
                                '<div class="user_info">' +
                                    '<a href="/p/'+username+'" class="name">'+name+' <span>replied:</span></a> <span class="date">Now</span>' +
                                '</div>' +
                                '<div class="reply_content">' +
                                    '<p>'+blipContent+'</p>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                );
                busy = false;
            }
        }
    });
}

document.querySelectorAll('.blip-reply-form').forEach(item => {
    item.addEventListener('submit', event => {
        event.preventDefault();
        replyBlip(event);
    })
});

/**
 * Open Blip reply form
    */
const openBlipReplyForm = (id) => {
    $('#blip-reply-form-' + id).fadeToggle('slow');
}

document.querySelectorAll('.reply').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        openBlipReplyForm(item.dataset.bid);
    })
});

/**
 * Like Blip function
 * @param {int} id 
 */
const likeBlip = (id) => {
    $.ajax({
        url: '/blip/like',
        type: 'POST',
        data: {
            blip_id: id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result){
            if(result.status == 'success' && result){
                $('#blip-like-btn-' + id).addClass('hidden');
                $('#blip-unlike-btn-' + id).removeClass('hidden');
            }
        }
    });
}

document.querySelectorAll('.like').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        likeBlip(item.dataset.id);
    })
});

/**
 * Unlike Blip function
 *  @param {int} id 
 */
const unlikeBlip = (id) => {
    $.ajax({
        url: '/blip/unlike',
        type: 'POST',
        data: {
            blip_id: id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result){
            if(result.status == 'success' && result){
                $('#blip-unlike-btn-' + id).addClass('hidden');
                $('#blip-like-btn-' + id).removeClass('hidden');
            }
        }
    });
}

document.querySelectorAll('.unlike').forEach(item => {
    item.addEventListener('click', event => {
        event.preventDefault();
        unlikeBlip(item.dataset.id);
    })
});

// Conversation ajax functions

/**
 * Send message function
 * 
 * @param {int} id
 * @param {string} content
 */
const sendMessage = (id, content) => {
    if(busy) return false;

    busy = true;

    if(id != '' && content != ''){
        $.ajax({
            url: '/messages/send',
            type: 'POST',
            data: {
                conversation_uid: id,
                message: content,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result){
                var message = '<div class="conversations-right-body-message conversations-right-body-message-me '+result.conversation_message_uid+'">';
                message += '<div class="conversations-right-body-message-inner">';
                message += '<div class="conversations-right-body-message-left">';
                message += '<div class="conversations-right-body-message-left-inner">';
                message += '<a class="conversations-right-body-message-left-avatar" href="/p/'+result.author.username+'">';
                message += '<img src="/usr_data/'+result.author.avatar+'" alt="'+result.author.name+'">';
                message += '</a>';
                message += '</div>';
                message += '</div>';
                message += '<div class="conversations-right-body-message-right">';
                message += '<div class="conversations-right-body-message-right-inner">';
                message += '<div class="conversations-right-body-message-right-head">';
                message += '<div class="conversations-right-body-message-right-head-inner">';
                message += '<div class="conversations-right-body-message-right-head-left">';
                message += '<h3>'+result.author.name+'</h3>';
                message += '</div>';
                message += '</div>';
                message += '</div>';
                message += '<div class="conversations-right-body-message-right-body">';
                message += '<div class="conversations-right-body-message-right-body-inner">';
                message += '<p>'+result.conversation_message_content+'</p>';
                message += '</div>';
                message += '</div>';
                message += '</div>';
                message += '</div>';
                message += '</div>';
                message += '</div>';

                $('#conversations-right-body').append(message);

                // Scroll to bottom
                var objDiv = document.getElementById("conversations-right-body");
                objDiv.scrollTop = objDiv.scrollHeight;

                // Empty textarea
                $('#message-textarea').val('');
                busy = false;
            }
        });
    } else {
        alert('Invalid message');
        busy = false;
    }
}

document.querySelector('#message-form').addEventListener('submit', event => {
    event.preventDefault();

    const conversation_id = document.querySelector('#conversation_uid').value;
    const content = document.querySelector('#message-textarea').value;

    sendMessage(conversation_id, content);
});

/**
 * Pusher
 */
const pusher_app_key = process.env.MIX_PUSHER_APP_KEY;
const pusher_app_cluster = process.env.MIX_PUSHER_APP_CLUSTER;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusher_app_key,
    cluster: pusher_app_cluster,
    encrypted: true,
});

// Listen for messages
var conversation = document.querySelector('#conversation_uid');

if(conversation){
    // Scroll to bottom
    var objDiv = document.getElementById("conversations-right-body");
    objDiv.scrollTop = objDiv.scrollHeight;

    // Listen for new messages
    window.Echo.private('conversation.' + conversation.value).listen('MessagePosted', (e) => {
        console.log(e);
        // Append new message
        $('#conversations-right-body').append(
            '<div class="message-item">' +
                '<div class="message-content">' +
                    '<p>' + e.message + '</p>' +
                '</div>' +
            '</div>'
        );

        // Scroll to bottom
        var objDiv = document.getElementById("conversations-right-body");
        objDiv.scrollTop = objDiv.scrollHeight;
    });
}