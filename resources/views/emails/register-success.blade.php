@extends ('emails.welcome')
@section ('content')

<section class="section is-mobile">
    <div class="container" style="width: 570px;">
        
        <h4 class="title is-4"> Welcome to {{ config('app.name') }}, {{ $oUser->name }}</h4>
        
        <div class="box">
            <h6 class="title is-6">Introduction</h6>

            <span>Thank you so much for registering!</span>

            <section class="section">
                <a class="button is-primary is-fullwidth" target="_blank" href="{{ url('http://127.0.0.1:8000/') }}">Start your Journals</a>
            </section>

            <span>Thanks,</span>
            <br>
            <span>{{ config('app.name') }}</span>
        </div>
    </div>
</section>

@endsection