<?php
$title = "Reset Password";
$description = "Let's reset your password.";
?>


@extends('layouts.guest')

@section('content')
    <div class="welcome-jumbotron">
        <div class="inner-welcome-jumbotron container-lg">
            <div class="row">
                <div class="left-welcome col-lg-12">
                    <h1 class="text-center"><?php echo $title; ?></h1>
                    <p class="text-center"><?php echo $description; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-auth container">
        <div class="welcome-auth-inner">
            <form method="POST" action="{{ route('password.update') }}">
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
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="">
                    <label for="email" value="Email">Email</label>

                    <div class="inputField">
                        <input id="email" class="block mt-1 w-full" type="email" name="email" value="<?php old('email', $request->email); ?>" required />
                    </div>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" value="__('Password')">Password</label>

                    <div class="inputField">
                        <input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" value="__('Confirm Password')">Confirm Password</label>

                    <div class="inputField">
                        <input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4" style="justify-content: space-between;">

                    <button class="btn btn-primary-dark">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
