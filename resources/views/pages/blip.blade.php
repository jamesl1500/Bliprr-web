<?php
$title = "View Blip";
$description = "Search for blips, users and more!";
$showbtn = false;

// Check if blip exists
if (isset($id) && !empty($id)) {
    $blip_id = $id;
    $blip = DB::table('blips')->where('buid', $blip_id)->first();

    if ($blip) {
        // Get blip author info
        $blip_author = DB::table('users')->where('id', $blip->blip_author)->first();

        $description = "View Blip posted by " . $blip_author->name . "!";
    }else{
        $title = "Blip not found";
        $description = "The blip you are looking for does not exist.";

        $showbtn = true;
    }
}else{
    $title = "Blip not found";
    $description = "The blip you are looking for does not exist.";

    $showbtn = true;
}
?>

@extends('layouts.logged')

@section('content')
    <div class="page page-blip-view">
        <div class="page-head">
            <div class="page-head-inner container-lg container-md container-sm">
                <div class="page-head-left">
                    <h1><?php echo $title; ?></h1>
                    <p><?php echo $description; ?></p>

                    <?php if ($showbtn) { ?>
                        <!-- Show back button -->
                        <a href="{{ route('timeline.index') }}" class="btn btn-primary">Back</a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="page-content container-lg container-md container-sm">
            <div class="row">
                <div class="left-blip-show col-lg-8">
                    <?php if($blip){ ?>
                        <x-blip blip="<?php echo $blip->id; ?>" openReply="true"/>
                    <?php } ?>
                </div>
                <div class="right-blip-show col-lg-4">
                    <!-- Blip author -->
                    <?php if($blip){ ?>
                        <div class="blip-author">
                            <div class="blip-author-inner">
                                <div class="blip-author-left">
                                    <a href="{{ route('profile.index', ['username' => $blip_author->username]) }}">
                                        <img src="{{ asset('usr_data/' . $blip_author->profile_picture) }}" alt="{{ $blip_author->username }}">
                                    </a>
                                </div>
                                <div class="blip-author-right">
                                    <a href="{{ route('profile.index', ['username' => $blip_author->username]) }}">
                                        <h4>{{ ucwords( $blip_author->name ) }}</h4>
                                        <h3>{{ $blip_author->username }}</h3>
                                        <p>{{ $blip_author->bio }}</p>
                                    </a><br />
                                    <?php
                                        // Show follow button if logged user is not the same as the profile user
                                        if(Auth::check())
                                        {
                                            if(Auth::user()->id != $blip_author->id)
                                            {
                                                // Check if logged user is following the profile user
                                                if(Auth::user()->followings->contains('followee_id', $blip_author->id))
                                                {
                                                    ?>
                                                        <form action="{{ route('unfollow') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $blip_author->id }}">
                                                            <button type="submit" class="btn btn-primary">Unfollow</button>
                                                        </form>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <form action="{{ route('follow') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $blip_author->id }}">
                                                            <button type="submit" class="btn btn-primary-dark">Follow</button>
                                                        </form>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                    <a href="{{ route('settings.index') }}" class="btn btn-primary-dark" style="width: 100%;">Settings</a>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                                <a href="{{ route('login') }}" class="btn btn-primary-dark" style="width: 100%;">Login</a>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
@endsection