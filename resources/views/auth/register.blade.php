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
                    <h1 class="text-center">Sign Up</h1>
                    <p class="text-center">Join in on all of the fun!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-auth container">
        <div class="welcome-auth-inner">
            <form method="POST" action="{{ route('register') }}">
                @csrf
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
                <!-- Name -->
                <div>
                    <label for="name" value="Name">Name</label>

                    <div class="inputField">
                        <input id="name" class="block mt-1 w-full" type="text" name="name" value="<?php old('name'); ?>" required autofocus />
                    </div>
                </div>

                <!-- Username -->
                <div class="mt-4">
                    <label for="username" value="Name">Username</label>

                    <div class="inputField">
                        <input id="username" class="block mt-1 w-full" type="text" name="username" value="<?php old('Username'); ?>" required autofocus />
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" value="Email">Email</label>

                    <div class="inputField">
                        <input id="email" class="block mt-1 w-full" type="email" name="email" value="<?php old('email'); ?>" required />
                    </div>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" value="Password">Password</label>

                    <div class="inputField">
                        <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" value="Confirm Password">Confirm Password</label>

                    <div class="inputField">
                        <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4" style="justify-content: space-between;">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" style="float: left;" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button class="btn btn-primary-dark">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection