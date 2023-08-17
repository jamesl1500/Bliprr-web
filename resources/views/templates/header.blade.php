<header class="header header-light container-lg container-md container-sm">
    <div class="header-inner row">
        <div class="header-branding col-lg-8 col-lg-8 col-md-8 col-sm-4 col-xs-4">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/bliprr_black_circle.png') }}" /> 
                <h3>Bliprr</h3>
            </a>
        </div>
        <div class="header-search col-lg-5" style="display: none">
            <form action="">
                <div class="inputField">
                    <input type="search" id="header-search" placeholder="Search for blips..." />
                </div>
            </form>
        </div>
        <div class="header-nav col-lg-4 col-md-4 col-sm-8 col-xs-8">
            <ul>
                <?php
                    if(Auth::check())
                    {
                        ?>
                            <li><a href="{{ route('timeline.index') }}">Timeline</a></li>
                            <li><a href="{{ route('settings.index') }}">Settings</a></li>
                            <li><a id="logoutBtnAction" data-csrf="{{ csrf_token() }}" href="{{ route('logout') }}">Logout</a></li>
                            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
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