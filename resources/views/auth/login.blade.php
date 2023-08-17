<?php
$title = "Login";
$description = "Jump back into the fun!";
?>

@extends('layouts.guest')

@section('content')
    <div class="welcome-jumbotron">
        <div class="inner-welcome-jumbotron container-lg">
            <div class="row">
                <div class="left-welcome col-lg-12">
                    <h1 class="text-center">Login</h1>
                    <p class="text-center">Jump back into the fun!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-auth container">
        <div class="welcome-auth-inner">
            <!-- Success Message -->
            <?php
            // Check if there are any errors
            if(session('status'))
            {
                ?>
                    <div class="alert alert-success">
                        <?php echo session('status'); ?>
                    </div>
                <?php
            }
            ?>
            
            <!-- Error Messages -->
            <?php
            // Check if there are any errors
            if($errors->any())
            {
                ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php
                                foreach($errors->all() as $error)
                                {
                                    ?>
                                        <li><?php echo $error; ?></li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </div>
                <?php
            }
            ?>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" :value="{{ __('Email') }}">Email</label>
                    <div class="inputField">
                        <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    </div>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" :value="{{ __('Password') }}">Password</label>

                    <div class="inputField">
                        <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4" style="justify-content: space-between;">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button class="btn btn-primary-dark ml-3" >
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
