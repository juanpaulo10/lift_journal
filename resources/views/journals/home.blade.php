@extends ('layouts.master') 

@section ('content')
<section class="section">
    <div class="container">
        <div class="columns is-mobile is-centered">
            <div class="box column is-half m-b-30">
                @include ('journals.create')
            </div>
        </div>

        <div class="columns is-centered is-mobile ">
            <div class="box column is-two-thirds m-b-30">
                <article class="media">
                    <div class="media-left">
                        <figure class="image is-64x64">
                            <img src="http://bulma.io/images/placeholders/128x128.png" alt="Image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong>John Smith</strong> <small>@johnsmith</small> <small>31m</small>
                                <br> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean efficitur sit amet
                                massa fringilla egestas. Nullam condimentum luctus turpis.
                            </p>
                        </div>
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <a class="level-item">
                                    <span class="icon is-small"><i class="fa fa-reply"></i></span>
                                </a>
                                <a class="level-item">
                                    <span class="icon is-small"><i class="fa fa-retweet"></i></span>
                                </a>
                                <a class="level-item">
                                    <span class="icon is-small"><i class="fa fa-heart"></i></span>
                                </a>
                            </div>
                        </nav>
                    </div>
                </article>
            </div>
        </div>


    </div>
</section>
@endsection