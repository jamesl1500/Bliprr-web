<div class="blip" id="blip-<?php echo $blip_info['id']; ?>">
    <div class="blip-inner">
        <div class="blip-head">
            <div class="blip-author">
                <div class="blip-author-avatar">
                    <div class="profile_image" style="background-image: url('/usr_data/<?php echo $user['profile_picture']; ?>');"></div>
                </div>
                <div class="blip-author-name">
                    <a class="blip-name" href="/p/<?php echo $user['username']; ?>"><?php echo ucwords($user['name']); ?> </a>
                    <a class="blip-username" href="/p/<?php echo $user['username']; ?>"><?php echo $user['username']; ?> &middot; <span class="blip-date"><?php echo date('m/d/Y', strtotime($blip_info['created_at'])); ?></span></a>
                </div>
            </div>
        </div>
        <div class="blip-content">
            <p class="blip-content-text"><?php echo $blip_info['blip_content']; ?></p>
        </div>
        <div class="blip-actions">
            <?php
            if(Auth::check())
            {
            ?>
                <div class="blip-actions-inner">
                    <a href="#" class="blip-action reply" data-bid="<?php echo $blip_info['id']; ?>"><i class="fas fa-reply"></i></a>
                    
                    <?php
                    $isLiked = App\Models\Blip_likes::where('buid', $blip_info['id'])->where('liker_id', Auth::user()->id)->first();   
                    
                    if($isLiked)
                    {
                    ?>
                        <a href="#" id="blip-like-btn-<?php echo $blip_info['id']; ?>" data-id="<?php echo $blip_info['id']; ?>" class="blip-action hidden like"><i class="fas fa-heart"></i></a>
                        <a href="#" id="blip-unlike-btn-<?php echo $blip_info['id']; ?>" data-id="<?php echo $blip_info['id']; ?>" class="blip-action unlike"><i class="fas fa-heart"></i></a>
                    <?php
                    }else{
                    ?>
                        <a href="#" id="blip-like-btn-<?php echo $blip_info['id']; ?>" data-id="<?php echo $blip_info['id']; ?>" class="blip-action like"><i class="fas fa-heart"></i></a>
                        <a href="#" id="blip-unlike-btn-<?php echo $blip_info['id']; ?>" data-id="<?php echo $blip_info['id']; ?>" class="blip-action hidden unlike"><i class="fas fa-heart"></i></a>
                    <?php
                    }

                    if(Auth::user()->id == $user['id'])
                    {
                    ?>
                        <a href="#" data-id="<?php echo $blip_info['id']; ?>" class="blip-action delete"><i class="fas fa-trash"></i></a>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>
                <p>Login to interact with this post</p>
            <?php
            }
            ?>
        </div>
        <?php
            if(Auth::check())
            {
        ?>
            <div class="blip-reply" id="blip-reply-form-<?php echo $blip_info['id']; ?>">
                <!-- Blip reply form -->
                <P>Reply to <?php echo ucwords($user['name']); ?></P>
                <form action="/blip/reply" method="POST" class="blip-reply-form" id="blip-reply-form-<?php echo $blip_info['id']; ?>" data-bid="<?php echo $blip_info['id']; ?>">
                    <input type="text" name="reply_content" id="blip-reply-textarea-<?php echo $blip_info['id']; ?>" class="blip-reply-textarea" placeholder="Whats up?" />
                    <input type="submit" class="btn btn-primary-dark blip-reply-submit" value="Reply" />
                </form>
            </div>
        <?php
            }
       
            $blip_replies = App\Models\Blip_reply::where('buid', $blip_info['id'])->take(3)->get()->toArray();
                
            if(count($blip_replies) > 0)
            {
                ?>
                <div class="blip-replies" id="blip-replies-holder-<?php echo $blip_info['id']; ?>">
                    <?php
                        // Get blip replies from database
                        foreach($blip_replies as $blip_reply)
                        {

                            // Get user info
                            $user = App\Models\User::where('id', $blip_reply['replyer_id'])->first()->toArray();
                        ?>
                            <div class="blip-reply-item" id="blip-reply-<?php echo $blip_reply['ruid']; ?>">
                                <div class="inner-blip-reply-item">
                                    <div class="profile_image" style="background-image: url('/usr_data/<?php echo $user['profile_picture']; ?>');"></div>
                                    <div class="right_information">
                                        <div class="user_info">
                                            <a href="/p/<?php echo $user['username']; ?>" class="name"><?php echo ucwords($user['name']); ?> <span>replied:</span></a> <span class="date"><?php echo date('m/d/Y', strtotime($blip_reply['created_at'])); ?></span>
                                        </div>
                                        <div class="reply_content">
                                            <p><?php echo $blip_reply['reply_content']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if(count($blip_replies) > 3)
                        {
                            ?>
                                <button class="btn btn-primary-dark blip-replies-view-more" data-bid="<?php echo $blip_info['id']; ?>">View more replies</button>
                            <?php
                        }
                    
                    ?>
                </div>
        <?php
            }else{

            }
        ?>
    </div>
</div>