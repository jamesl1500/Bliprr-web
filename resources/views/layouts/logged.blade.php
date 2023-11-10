<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">

    <!-- Title -->
    <title><?php if(isset($title) && $title != "") { echo $title . " | "; } ?><?php echo env('APP_NAME'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <link rel="shortcut icon" href="{{ asset('images/bliprr_black_circle.png') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/8ea51260da.js" crossorigin="anonymous"></script>

    <!-- Base url html -->
    <base href="{{ url('/') }}">
</head>
<body>
<div class="header-hold">
    @include('templates.header')
</div>
<div class="website-hold">
    @yield('content')
</div>
<div class="footer-hold">
    @include('templates.footer')
</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script src="{{ asset('js/scripts.js') }}"></script>

@env('local')
    <script src="http://localhost:35729/livereload.js"></script>
@endenv
</body>
</html>