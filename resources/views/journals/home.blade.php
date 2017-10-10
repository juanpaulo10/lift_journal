@extends ('layouts.master') 

@section ('content')
<section class="section">
    <div class="container">
    
        <div class="columns is-mobile is-centered">
            <div class="box column is-half m-b-30">
                @include ('journals.create')
            </div>
        </div>

        <div id="flash-msg" v-if="message" class="notification is-success" role="alert">
            <p v-text="message"></p>
        </div>

        @include ('journals.feed')

    </div>
</section>
@endsection