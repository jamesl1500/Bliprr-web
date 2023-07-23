<header class="header header-light container-lg">
    <div class="header-inner row">
        <div class="header-branding col-lg-3">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/bliprr_black_circle.png') }}" /> 
                <h3>Bliprr</h3>
            </a>
        </div>
        <div class="header-search col-lg-5">
            <form action="">
                <div class="inputField">
                    <input type="search" id="header-search" placeholder="Search for blips..." />
                </div>
            </form>
        </div>
        <div class="header-nav col-lg-4">
            <ul>
                <?php
                    if(Auth::check())
                    {
                        ?>
                            <li><a href="{{ route('home') }}">Timeline</a></li>
                            <li><a href="/profile/<?php echo Auth::user()->username; ?>">Profile</a></li>
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        <?php
                    }else {
                        ?>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Sign Up</a></li>
                <?php
                    }
                ?>
            </ul>
        </div>
    </div>
</header>