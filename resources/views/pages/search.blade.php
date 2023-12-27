<?php
$title = "Search";
$description = "Search for blips, users and more!";
?>

@extends('layouts.logged')

@section('content')
    <div class="page page-search">
        <div class="page-head">
            <div class="page-head-inner container-lg container-md container-sm">
                <div class="page-head-left">
                    <h1><?php echo $title; ?></h1>
                    <p><?php echo $description; ?></p>
                </div>
            </div>
        </div>
        <div class="page-content container-lg container-md container-sm">
            <!-- Search Input -->
            <div class="search-input">
                <form action="" method="GET">
                    <input type="text" name="search" placeholder="Search for blips, users and more!" value="{{ $search }}">
                </form>
            </div>

            <!-- Users -->
            <div class="search-users">
                <div class="search-users-inner">
                    <div class="search-users-top">
                        <div class="search-users-top-left">
                            <h2>Users</h2>
                        </div>
                        <div class="search-users-top-right">
                            @if(count($users) > 6)
                                <a href="{{ route('search.index', ['search' => $search, 'type' => 'users']) }}">View all</a>
                            @endif
                        </div>
                    </div>
                    <div class="search-users-list">
                        @if(count($users) > 0)
                            @foreach($users as $user)
                                <div class="search-users-list-item">
                                    <div class="search-users-list-item-left">
                                        <a href="{{ route('profile.index', ['username' => $user->username]) }}">
                                            <img src="{{ asset('usr_data/' . $user->profile_picture) }}" alt="{{ $user->username }}">
                                        </a>
                                    </div>
                                    <div class="search-users-list-item-right">
                                        <a href="{{ route('profile.index', ['username' => $user->username]) }}">
                                            <h4>{{ ucwords( $user->name ) }}</h4>
                                            <h3>{{ $user->username }}</h3>
                                        </a>
                                    </div>
                                    <div class="search-users-bottom-actions">
                                        <a href="{{ route('profile.index', ['username' => $user->username]) }}">View Profile</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No users found.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Blips -->
            <div class="search-blips">
                <div class="search-blips-inner">
                    <div class="search-blips-top">
                        <div class="search-blips-top-left">
                            <h2>Blips</h2>
                        </div>
                        <div class="search-blips-top-right">
                            @if(count($blips) > 4)
                                <a href="{{ route('search.index', ['search' => $search, 'type' => 'blips']) }}">View all</a>
                            @endif
                        </div>
                    </div>
                    <div class="search-blips-list">
                        @if(count($blips) > 0)
                            @foreach($blips as $blip)
                                <x-blip blip="<?php echo $blip->id; ?>"/>
                            @endforeach
                        @else
                            <p>No blips found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection