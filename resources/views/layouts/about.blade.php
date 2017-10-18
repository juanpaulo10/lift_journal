@extends ('layouts.master') 
@section ('content')
<section class="hero is-primary is-medium">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                About
            </h1>
            <h2 class="subtitle">
                Lift Journal
            </h2>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="content">
            <h2>
                A Simple
                <a href="https://laravel.com/">Laravel</a>
                <sub>5.5</sub> App, made with
                <a href="https://bulma.io/">Bulma.io</a>
            </h2>
            <blockquote>
                <p>This is just a demonstration of skill sets, the app is not meant to follow other users or read and like their
                    posts which is prevalent in social media.</p>
            </blockquote>

            <h3>A Realtime app for Gym Rats!</h3>
            <p>
                It serves as a simple diary for gym passionates by logging their workout sessions.
            </p>

            <h3> Features </h3>
            <p>
                You can
                <strong>add</strong> multiple exercises and post your thoughts.
            </p>
            <p>
                You can
                <strong>delete</strong> your existing posts, or just in case,
                <strong>edit</strong> them yourself if you made a mistake.
            </p>

            <h3>Some notable features</h3>
            <p>
                This app comes with
                <a href="https://www.npmjs.com/package/redis">Redis</a>
                <sub>2.8</sub>,
                <a href="https://socket.io/">Socket.io</a>
                <sub>2.0</sub> and
                <a href="https://expressjs.com/">Express</a>
                <sub>4.16.2</sub> to have a server to fire off events realtime to other connections.
            </p>
            <p>Simple Scenario:</p>
            <ul>
                <li>A browser with the app creates a post.</li>
                <li>Another existing browser/app (unique) will be able to receive the post created. Almost instantly (it still
                    has process to take).</li>
            </ul>
            <blockquote>
                Keep in mind that when a post is deleted or edited, it will not notify any existing app, it will happen instantaneously.
            </blockquote>

            <h5>Others:</h5>
            <p>Similar to other laravel apps, it uses and/or supported by the following:</p>
            <ul>
                <li>Backend -
                    <strong>Laravel</strong>: </li>
                <ul>
                    <li>Middleware</li>
                    <li>Eloquent Model Relationships</li>
                    <li>Form Requests</li>
                    <li>
                        <a href="https://github.com/nrk/predis">Redis</a>
                        <sub>predis</sub> Publish ( Where events are sent to its Redis Server
                        <a href="https://www.npmjs.com/package/redis">Redis</a>
                        <sub>NodeRedis</sub> )
                    </li>
                </ul>

                <li>Frontend -
                    <strong>VueJS</strong>: </li>
                <ul>
                    <li>Vuex </li>
                    <li>
                        <a href="https://www.npmjs.com/package/axios">Axios</a>
                        <sub>0.16.2</sub> (Ajax)</li>
                    <li>
                        <a href="https://www.npmjs.com/package/vue-socket-io">Vue-socket.io</a>
                        <sub>0.3.2</sub>
                        (for listening to events emitted by Socket.io)</li>
                </ul>
            </ul>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="content has-text-centered">
            <p>
                <span class="icon">
                    <i class="fa fa-github"></i>
                </span>
                <a href="https://github.com/juanpaulo10/lift_journal">lift_journal</a>
            </p>
        </div>
    </div>
</footer>
@endsection