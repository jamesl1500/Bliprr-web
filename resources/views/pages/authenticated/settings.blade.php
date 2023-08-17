<?php
$title = "Settings";
$description = "Edit your profile settings.";
?>

@extends('layouts.logged')

@section('content')
    <div class="page-settings">
        <div class="page-settings-head">
            <div class="page-settings-head-inner container-lg">
                <div class="page-settings-head-left">
                    <h1>Settings</h1>
                    <p>Edit your profile settings.</p>
                </div>
            </div>
        </div>
        <div class="page-settings-bottom container-lg">
            @include('components.flash-messages')
            <div class="inner-settings-body">
                <!-- Profile Picture -->
                <form class="profile-picture-form" action="{{ route('settings.save.profile_picture') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Profile Picture -->
                    <div class="profile-picture">
                        <div class="profile-picture-inner">
                            <div class="profile-picture-left">
                                <h2>Profile Picture</h2>
                                <p>Upload a new profile picture.</p>
                            </div>
                            <div class="profile-picture-right">
                                <div class="profile-picture-right-inner">
                                    <div class="profile-picture-right-left">
                                        <img src="{{ asset('usr_data/' . Auth::user()->profile_picture) }}" alt="Profile Picture">
                                    </div>
                                    <div class="profile-picture-right-right">
                                        <input type="file" name="profile_picture" id="profile_picture">
                                        <input type="submit" class="btn btn-primary-dark" value="Upload">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr /><br />
                <!-- Save basic info -->
                <form class="profile-picture-form" action="{{ route('settings.save.info') }}" method="post" enctype="multipart/form-data" class="col-lg-4">
                    @csrf
                    <div class="profile-picture">
                        <div class="profile-picture-inner">
                            <div class="profile-picture-left">
                                <h2>Basic Information</h2>
                                <p>Update your basic information</p>
                            </div>
                        </div>
                        <br />
                        <!-- Name -->
                        <div class="col-lg-4">
                            <label for="name" :value="{{ __('Name') }}">Name</label>
                            <div class="inputField">
                                <input id="name" class="block mt-1 w-full" type="text" name="name" value="<?php echo Auth::user()->name; ?>" required />
                            </div>
                        </div>
                        <br />
                        <!-- Email Address -->
                        <div class="col-lg-4">
                            <label for="email" :value="{{ __('Email') }}">Email</label>
                            <div class="inputField">
                                <input id="email" class="block mt-1 w-full" type="email" name="email" value="<?php echo Auth::user()->email; ?>" required  />
                            </div>
                        </div>
                        <br />
                        <!-- Bio -->
                        <div class="col-lg-4">
                            <label for="email" :value="{{ __('Email') }}">Email</label>
                            <div class="inputField">
                                <textarea id="bio" class="block mt-1 w-full" name="bio" required><?php echo Auth::user()->bio; ?></textarea>
                            </div>
                        </div>
                        <br />
                        <!-- Submit -->
                        <div class="col-lg-4">
                            <input type="submit" class="btn btn-primary-dark" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection