<div class="blip">
    <div class="blip-inner">
        <div class="blip-head">
            <div class="blip-author">
                <div class="blip-author-avatar">
                    <img src="https://via.placeholder.com/50" alt="Avatar">
                </div>
                <div class="blip-author-name">
                    <a class="blip-name" href="/p/<?php echo $user['username']; ?>"><?php echo ucwords($user['name']); ?></a>
                    <a class="blip-username" href="/p/<?php echo $user['username']; ?>"><?php echo $user['username']; ?></a>
                    <p>
                        <span class="blip-date"><?php echo $blip_info['created_at']; ?></span>
                    </p>
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
                    <a href="#" class="blip-action reply"><i class="fas fa-reply"></i></a>
                    <a href="#"  class="blip-action reblip"><i class="fas fa-retweet"></i></a>
                    <a href="#" class="blip-action like"><i class="fas fa-heart"></i></a>
                    <?php

                    if(Auth::user()->id == $user['id'])
                    {
                    ?>
                        <a href="#" class="blip-action delete"><i class="fas fa-trash"></i></a>
                    <?php
                    }
                    ?>
                </div>
            <?php
            } else {
            ?>

            <?php
            }
            ?>
        </div>
        <?php
            if(Auth::check())
            {
        ?>
            <div class="blip-reply">

            </div>
        <?php
            }
        ?>
        <div class="blip-replies">
            <?php
                // Get blip replies from database
                $blip_replies = App\Models\Blip_reply::where('buid', $blip_info['buid'])->take(3)->get()->toArray();
                
                foreach($blip_replies as $blip_reply)
                {
            ?>
                    <div class="blip-reply" id="blip-reply-<?php echo $blip_reply['ruid']; ?>">

                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>