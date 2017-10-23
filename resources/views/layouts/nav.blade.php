  @if ( auth()->check() !== true )  {{-- If user not logged in. --}}
    <div class="container ">

        <profile-menu inline-template v-cloak>

            <nav class="navbar ">
                <div class="navbar-brand">
                    <a href="{{ App\Helpers::isCurrPage('login') }}" class="navbar-item">
                        Lift Journal
                    </a>

                    <div class="navbar-burger burger" 
                        data-target="navMenuDocumentation"
                        @click.stop="toggle"
                        v-on-clickaway="off" >
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div id="navMenuDocumentation" 
                    class="navbar-menu"
                    :class="{ 'is-active' : isActive }">
                    <div class="navbar-start">
                        <a class="navbar-item" href=" {{ App\Helpers::isCurrPage('register') }} ">
                            Register
                        </a>

                        <a class="navbar-item" href=" {{ App\Helpers::isCurrPage('about') }} ">
                            About
                        </a>

                    </div>
                </div>
            </nav>

        </profile-menu>
    </div>
@else
    {{--  user logged in  --}}
    <section class="hero is-primary is-medium">
        <!-- Hero header: will stick at the top -->
        <div class="hero-head">
            <header class="nav">
                <div class="container">
                    
                    <div class="nav-left">
                        <a class="nav-item title is-4" href="{{ url('/home') }}">
                            Lift Journal
                        </a>
                    </div>

                    <profile-menu inline-template v-cloak>
                    <div>
                        <span class="nav-toggle" 
                            @click.stop="toggle"
                            v-on-clickaway="off">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>

                        <div class="nav-right nav-menu" :class="{ 'is-active' : isActive }">
                            <p class="nav-item">
                                {{ auth()->user()->name }}
                            </p>

                            <a class="nav-item" href="{{ url('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    </profile-menu>

                </div>
            </header>
        </div>

        <!-- Hero footer: will stick at the bottom -->
        <div class="hero-foot">
            @include ('journals.nav')
        </div>
    </section>

@endif