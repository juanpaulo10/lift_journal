@extends ('layouts.master')
@section ('content')
<section class="section columns">
    <div class="column">

        <div class="columns is-mobile is-centered">
            <div class="box column is-half m-b-30">
                @include ('journals.create')
            </div>
        </div>

        @include ('journals.feed')
        @include ('journals.edit')
    </div>

    <aside class="is-narrow-mobile is-fullheight is-hidden-mobile sidebar-column">
        @include ('journals.sidebar')
    </aside>
</section>
@endsection