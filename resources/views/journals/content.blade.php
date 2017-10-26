
@if ( count($aJournals) > 0 )

@foreach($aJournals as $aJournal)
    
        <p>{{ $aJournal['title'] }}</p>
        <hr>
    
@endforeach


@else
    <p class="nothing-more">
        Nothing to show.
    </p>
@endif