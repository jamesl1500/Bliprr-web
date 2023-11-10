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