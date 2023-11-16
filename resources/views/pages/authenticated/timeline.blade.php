<?php
$title = "Timeline";
$description = "Here are the latest blips from your feed.";
?>

@extends('layouts.logged')

@section('content')
    <div class="page-timeline">
        <div class="timeline-head">
            <div class="timeline-head-inner container-lg container-md container-sm">
                <div class="timeline-head-left">
                    <h1>Timeline</h1>
                    <p>Here are the latest blips from your feed.</p>
                </div>
                <div class="timeline-head-bottom col-lg-8">
                    <form action="{{ route('blip.create') }}" method="post">
                        @csrf
                        <div class="error" style="width: 99%;">
                            @if($errors->has('blip_content'))
                                <p class="alert alert-danger">{{ $errors->first('blip_content') }}</p>
                            @endif
                        </div>
                        <div class="success" style="width: 99%;">
                            @if(Session::has('blip_created'))
                                <p>{{ Session::get('blip_created') }}</p>
                            @endif
                        </div>
                        <div class="inputField">
                            <textarea style="background-color: white;" name="blip_content" id="blip" placeholder="What's on your mind?"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Post Blip">
                    </form>
                </div>
            </div>
        </div>
        <div class="timeline-body container-lg container-md container-sm">
            <div class="timeline-body-inner row">
                <div class="timeline-left-body col-lg-8">
                <!-- Latest Blips -->
                <?php
                    // Gather logged users followings
                    $followings = Auth::user()->followings->toArray();

                    // Add logged user to followings array
                    array_push($followings, array('followee_id' => Auth::user()->id));

                    // Gather logged users followings ids
                    $followings_ids = array_column($followings, 'followee_id');

                    // Gather blips from logged users followings
                    $blips = App\Models\Blips::whereIn('blip_author', $followings_ids)->orderBy('created_at', 'desc')->get()->toArray();

                    // Display blips if there are any
                    if(count($blips) > 0)
                    {
                        foreach($blips as $blip) 
                        {
                            ?>
                                <x-blip blip="<?php echo $blip['id']; ?>"/>
                            <?php
                        }
                    }else{
                        ?>
                            <div class="no-blips">
                                <div class="no-blips-inner">
                                    <div class="no-blips-left">
                                        <p>No blips yet!</p>
                                    </div>
                                    <div class="no-blips-right">
                                        <p>Follow someone to see their blips!</p>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                
                ?>
                </div>
                <div class="timeline-right-body col-lg-4">
                    <!-- Notifications Card -->
                    <div class="notifications-card">
                        <div class="notifications-card-inner">
                            <div class="notifications-card-head">
                                <h2>Notifications</h2>
                                <p>Here are your latest notifications.</p>
                            </div>
                            <div class="notifications-card-body">
                                <?php
                                    // Get unread notifications
                                    $unread_notifications = auth()->user()->unreadNotifications->toArray();

                                    // Get read notifications
                                    $read_notifications = auth()->user()->readNotifications->toArray();

                                    // Merge notifications
                                    $notifications = array_merge($unread_notifications, $read_notifications);

                                    // Display notifications
                                    foreach($notifications as $notification) 
                                    {
                                        ?>
                                            <x-notification notification="<?php echo $notification['id']; ?>"/>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
            
                    <!-- Trending blippers -->
                    <div class="trending-blippers">
                        <div class="trending-blippers-inner">
                            <div class="trending-blippers-head">
                                <h2>Trending Blippers</h2>
                                <p>Here are the blippers that are trending on Bliprr.</p>
                            </div>
                            <div class="trending-blippers-body">
                                <?php
                                    $users = App\Models\User::orderBy('created_at', 'desc')->take(3)->get()->toArray();

                                    foreach($users as $user) 
                                    {
                                        ?>
                                            <div class="trending-blipper">
                                                <div class="trending-blipper-inner">
                                                    <div class="trending-blipper-left">
                                                        <a href="/p/<?php echo $user['username']; ?>" class="trending-blipper-avatar">
                                                            <div class="profile_image" style="background-image: url('/usr_data/<?php echo $user['profile_picture']; ?>');"></div>
                                                        </a>
                                                    </div>
                                                    <div class="trending-blipper-right">
                                                        <div class="trending-blipper-right-inner">
                                                            <a href="/p/<?php echo $user['username']; ?>" class="trending-blipper-username">
                                                                <h3>{{ $user['name'] }}</h3>
                                                            </a>
                                                            <p class="trending-blipper-blips">{{ $user['username'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                    }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection