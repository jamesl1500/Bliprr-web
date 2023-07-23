@extends('layouts.guest')

@section('content')
    <div class="welcome-jumbotron">
        <div class="inner-welcome-jumbotron container-lg">
            <div class="row">
                <div class="left-welcome col-lg-6">
                    <h1>Welcome to Bliprr</h1>
                    <p>Bliprr is a social media platform that allows you to share your thoughts and ideas with the world.</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                </div>
                <div class="right-welcome col-lg-6">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-latest container-lg">
        <div class="top-latest">
            <div class="left-latest col-lg-6">
                <h2>Latest Blips</h2>
                <p>Here are the latest blips from our users.</p>
            </div>
        </div>
        <div class="bottom-latest">
            <!-- Latest Blips -->
            <?php
                $blips = App\Models\Blips::orderBy('created_at', 'desc')->take(6)->get()->toArray();

                foreach($blips as $blip) 
                {
                    ?>
                        <x-blip blip="<?php echo $blip['id']; ?>"/>
                    <?php
                }
            
            ?>
        </div>
    </div>
@endsection