@extends('layouts.logged')

@section('content')
    <div class="page-profile-top">
        <div class="page-profile-top-inner">
            <div class="page-profile-top-banner">

            </div>
            <div class="page-profile-bottom-info">
                <div class="profile-bottom-inner container-lg">
                    <div class="profile-bottom-left">
                        <div class="profile-bottom-left-inner">
                            <div class="profile-bottom-left-left">
                                <div class="profile-picture" style="background-image: url('{{ asset('usr_data/' . $user->profile_picture) }}');"></div>
                            </div>
                            <div class="profile-bottom-right-info">
                                <div class="profile-bottom-middle">
                                    <h1>{{ ucwords($user->name) }}</h1>

                                    <?php 
                                        if(Auth::check())
                                        {
                                            // Check to see if user is in profile users followings
                                            $isFollowing = App\Models\Followings::where('followee_id', Auth::user()->id)->where('follower_id', $user->id)->first();

                                            if($isFollowing)
                                            {
                                                ?>
                                                    <p>{{ $user->username }} &middot; Follows You</p>
                                                <?php
                                            }else{
                                                ?>
                                                    <p>{{ $user->username }}</p>
                                                <?php
                                            }
                                        }else{
                                    ?>
                                        <p>{{ $user->username }}</p>
                                    <?php
                                        }
                                    ?>

                                    <!-- Mobile bio -->
                                    <div class="profile-bottom-mobile-bio">
                                        <p>{{ $user->bio }}</p>
                                    </div>
                                </div>
                                <div class="profile-bottom-right">
                                    <div class="profile-stats">
                                        <div class="profile-stats-inner">
                                            <div class="profile-stats-item">
                                                <div class="profile-stats-item-inner">
                                                    <div class="profile-stats-item-left">
                                                        <p>Blips</p>
                                                    </div>
                                                    <div class="profile-stats-item-right">
                                                        <p>{{ $user->blips->count() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-stats-item">
                                                <div class="profile-stats-item-inner">
                                                    <div class="profile-stats-item-left">
                                                        <p>Followers</p>
                                                    </div>
                                                    <div class="profile-stats-item-right">
                                                        <p>{{ $user->followers->count() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-stats-item">
                                                <div class="profile-stats-item-inner">
                                                    <div class="profile-stats-item-left">
                                                        <p>Following</p>
                                                    </div>
                                                    <div class="profile-stats-item-right">
                                                        <p>{{ $user->followings->count() }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="page-profile-mobile-actions">
                                    <?php
                                        // Show follow button if logged user is not the same as the profile user
                                        if(Auth::check())
                                        {
                                            if(Auth::user()->id != $user->id)
                                            {
                                                // Check if logged user is following the profile user
                                                if(Auth::user()->followings->contains('followee_id', $user->id))
                                                {
                                                    ?>
                                                        <form action="{{ route('unfollow') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <button type="submit" class="btn btn-primary">Unfollow</button>
                                                        </form>
                                                    <?php
                                                }else{
                                                    ?>
                                                        <form action="{{ route('follow') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-profile-bottom">
        <div class="page-profile-bottom-inner container-lg">
            <div class="page-profile-bottom-row row">
                <div class="page-profile-bottom-left col-lg-3 col-md-3">
                    <div class="page-profile-actions">
                        <?php
                            // Show follow button if logged user is not the same as the profile user
                            if(Auth::check())
                            {
                                if(Auth::user()->id != $user->id)
                                {
                                    // Check if logged user is following the profile user
                                    if(Auth::user()->followings->contains('followee_id', $user->id))
                                    {
                                        ?>
                                            <form action="{{ route('unfollow') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-primary">Unfollow</button>
                                            </form>
                                        <?php
                                    }else{
                                        ?>
                                            <form action="{{ route('follow') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
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
                    <div class="page-profile-bio">
                        <div class="page-profile-bio-inner">
                            <div class="page-profile-bio-head">
                                <h2>Bio</h2>
                            </div>
                            <div class="page-profile-bio-body">
                                <p>{{ $user->bio }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-profile-bottom-middle col-lg-6 col-md-12">
                    @include('components.flash-messages')
                    <?php
                        // Display blips
                        if($user->blips->count() > 0)
                        {
                        foreach ($user->blips as $blip) {
                            ?>
                                <x-blip blip="{{ $blip->id }}"/>
                            <?php
                        }
                        }else{
                            ?>
                                <div class="no-blips">
                                    <div class="no-blips-inner">
                                        <div class="no-blips-left">
                                            <p>No blips yet!</p>
                                        </div>
                                        <?php if(Auth::check() && Auth::user()->id == $user->id){ ?>
                                            <div class="no-blips-right">
                                                <p>Blip something!</p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
@endsection