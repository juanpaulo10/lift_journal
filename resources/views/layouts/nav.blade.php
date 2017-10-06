@if ( auth()->check() !== true )
    <div class="container ">
        <nav class="navbar ">
            <div class="navbar-brand">
                <a href="#" class="navbar-item">
                    Lift Journal
                </a>

                <div class="navbar-burger burger" data-target="navMenuDocumentation">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div id="navMenuDocumentation" class="navbar-menu">
                <div class="navbar-start">

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link  is-active" href="/documentation/overview/start/">
                        Docs
                        </a>
                        <div class="navbar-dropdown ">
                            <a class="navbar-item " href="/documentation/overview/start/">
                                Overview
                            </a>
                            <a class="navbar-item " href="http://bulma.io/documentation/modifiers/syntax/">
                                Modifiers
                            </a>

                            <hr class="navbar-divider">
                            <div class="navbar-item">
                                <div>
                                    <p class="is-size-6-desktop">
                                        <strong class="has-text-info">0.5.3</strong>
                                    </p>

                                    <small>
                                        <a class="bd-view-all-versions" href="/versions">View all versions</a>
                                    </small>

                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="navbar-item" href="http://bulma.io/blog/">
                        Blog
                    </a>

                </div>
            </div>
        </nav>

    </div>
@else

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
                    <span class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                    </span>
                    <div class="nav-right nav-menu">
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
            </header>
        </div>

        <!-- Hero footer: will stick at the bottom -->
        <div class="hero-foot">
            @include ('journals.nav')
        </div>
    </section>

@endif