@extends('layouts.logged')

@section('content')
    <div class="page-timeline container-lg">
        <div class="timeline-head">
            <div class="timeline-head-inner">
                <div class="timeline-head-left">
                    <h1>Timeline</h1>
                    <p>Here are the latest blips from your feed.</p>
                </div>
                <div class="timeline-head-right">
                    <a href="" class="btn btn-primary-dark">Create a Blip</a>
                </div>
            </div>
        </div>
        <div class="timeline-body">
            <div class="timeline-body-inner row">
                <div class="timeline-left-body col-lg-8">
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
                <div class="timeline-right-body col-lg-4">
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
                                                        <a href="" class="trending-blipper-avatar">
                                                            <img src="https://via.placeholder.com/50" alt="Avatar">
                                                        </a>
                                                    </div>
                                                    <div class="trending-blipper-right">
                                                        <div class="trending-blipper-right-inner">
                                                            <a href="" class="trending-blipper-username">
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