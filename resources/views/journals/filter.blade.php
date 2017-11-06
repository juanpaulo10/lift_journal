@extends ('layouts.master')
@section ('content')
<section class="section columns">
    
    <div class="column is-8 ">
        @include ('journals.content')
    </div>

    <aside class="is-narrow-mobile is-fullheight is-hidden-mobile sidebar-column">
        @include ('journals.sidebar')
    </aside>

</section>
@endsection