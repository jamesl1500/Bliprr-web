<?php
$data = json_decode($note_data->data, true);

// Blip 
$blip = $data['blip'];
$blip_id = $blip['id'];
$blip_buid = $blip['buid'];

// No9tification
$type = $data['__type'];
$note_id = $note_data->id;

// Note from
switch($type)
{
    case 'BlipLike':
        $note_from = $data['liker'];
        $note_content = "liked your";
        $note_emoji = "fas fa-heart";
        break;
}
?>
<div class="notification" data-noteid="<?php echo $note_id; ?>">
    <div class="notification-inner">
        <div class="left-profile">
            <a href="/profile/<?php echo $note_from['username']; ?>">
                <div class="left-profile-picture" style="background-image: url('/usr_data/<?php echo $note_from['profile_picture']; ?>');" alt="<?php echo $note_from['name']; ?>"></div>
            </a>
        </div>
        <div class="right-note-info">
            <p><a href=""><?php echo ucwords($note_from['name']); ?></a> <?php echo $note_content; ?> <a href="/blip/<?php echo $blip_buid; ?>">blip</a></p>
            <p><span><i class="<?php echo $note_emoji; ?>"></i></span> &middot; <?php echo date('m/d/Y', strtotime($note_data->created_at)); ?></p>
        </div>
    </div>
</div>