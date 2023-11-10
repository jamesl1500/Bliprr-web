/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/scripts.js ***!
  \*********************************/
jQuery(function () {
  /**
   * Close alert
   */
  $('.close').click(function () {
    $('.alert').fadeOut('slow');
  });
});
var busy = false;

/**
 * Logout function
 */
var logout = function logout(e) {
  e.preventDefault();
  document.getElementById('logoutForm').submit();
};
document.getElementById('logoutBtnAction').addEventListener('click', logout);

// Blip ajax functions

/**
 * Delete Blip function
 * @param {int} id 
 */
var deleteBlip = function deleteBlip(id) {
  $.ajax({
    url: '/api/blip/delete',
    type: 'DELETE',
    data: {
      blip_id: id,
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(result) {
      if (result.status == 'success' && result) {
        $('#blip-' + id).fadeOut('slow');
      }
    },
    error: function error(result) {
      alert(result.message);
    }
  });
};
document.querySelectorAll('.delete').forEach(function (item) {
  item.addEventListener('click', function (event) {
    event.preventDefault();
    deleteBlip(item.dataset.id);
  });
});

/**
 * Reply Blip function
 */
var replyBlip = function replyBlip(e) {
  if (busy) return false;
  busy = true;
  e.preventDefault();
  var blipId = e.target.dataset.bid;
  var blipContent = document.getElementById('blip-reply-textarea-' + blipId).value;
  if (blipContent == '') {
    alert('Please enter a reply');
    return false;
  }
  if (blipId == '') {
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
    success: function success(result) {
      if (result.status == 'success' && result) {
        $('#blip-reply-form-' + blipId).fadeOut('slow');
        var profile_picture = result.reply_author_avatar;
        var username = result.reply_author_username;
        var name = result.reply_author_name;
        var content = result.reply_content;

        // Append reply to blip
        $('#blip-replies-holder-' + blipId).prepend('<div class="blip-reply-item" id="blip-reply-' + blipId + '">' + '<div class="inner-blip-reply-item">' + '<div class="profile_image" style="background-image: url(/usr_data/' + profile_picture + ');"></div>' + '<div class="right_information">' + '<div class="user_info">' + '<a href="/p/' + username + '" class="name">' + name + ' <span>replied:</span></a> <span class="date">Now</span>' + '</div>' + '<div class="reply_content">' + '<p>' + blipContent + '</p>' + '</div>' + '</div>' + '</div>' + '</div>');
        busy = false;
      }
    }
  });
};
document.querySelectorAll('.blip-reply-form').forEach(function (item) {
  item.addEventListener('submit', function (event) {
    event.preventDefault();
    replyBlip(event);
  });
});

/**
 * Open Blip reply form
    */
var openBlipReplyForm = function openBlipReplyForm(id) {
  $('#blip-reply-form-' + id).fadeToggle('slow');
};
document.querySelectorAll('.reply').forEach(function (item) {
  item.addEventListener('click', function (event) {
    event.preventDefault();
    openBlipReplyForm(item.dataset.bid);
  });
});

/**
 * Like Blip function
 * @param {int} id 
 */
var likeBlip = function likeBlip(id) {
  $.ajax({
    url: '/blip/like',
    type: 'POST',
    data: {
      blip_id: id,
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(result) {
      if (result.status == 'success' && result) {
        $('#blip-like-btn-' + id).addClass('hidden');
        $('#blip-unlike-btn-' + id).removeClass('hidden');
      }
    }
  });
};
document.querySelectorAll('.like').forEach(function (item) {
  item.addEventListener('click', function (event) {
    event.preventDefault();
    likeBlip(item.dataset.id);
  });
});

/**
 * Unlike Blip function
 *  @param {int} id 
 */
var unlikeBlip = function unlikeBlip(id) {
  $.ajax({
    url: '/blip/unlike',
    type: 'POST',
    data: {
      blip_id: id,
      _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(result) {
      if (result.status == 'success' && result) {
        $('#blip-unlike-btn-' + id).addClass('hidden');
        $('#blip-like-btn-' + id).removeClass('hidden');
      }
    }
  });
};
document.querySelectorAll('.unlike').forEach(function (item) {
  item.addEventListener('click', function (event) {
    event.preventDefault();
    unlikeBlip(item.dataset.id);
  });
});
/******/ })()
;