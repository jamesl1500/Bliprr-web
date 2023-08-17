<?php
$title = "Forgot Password";
$description = "Reset your password!";
?>


@extends('layouts.guest')

@section('content')
    <div class="welcome-jumbotron">
        <div class="inner-welcome-jumbotron container-lg">
            <div class="row">
                <div class="left-welcome col-lg-12">
                    <h1 class="text-center">Forgot Password</h1>
                    <p class="text-center">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-auth container">
        <div class="welcome-auth-inner">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

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
                <!-- Email Address -->
                <div class="">
                    <label for="email" value="Email">Email</label>

                    <div class="inputField">
                        <input id="email" class="block mt-1 w-full" type="email" name="email" value="<?php old('email'); ?>" required />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4" style="justify-content: space-between;">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" style="float: left;" href="{{ route('login') }}">
                        {{ __('Nevermind?') }}
                    </a>

                    <button class="btn btn-primary-dark">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
