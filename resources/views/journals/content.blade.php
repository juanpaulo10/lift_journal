@if ( count($aJournals) > 0 )

<h1 class="title is-1"> {{ request('month') }} Journals </h1>

<div>
    @foreach($aJournals as $aJournal)

    <div class="card filter-card">
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-4">{{ $aJournal['title'] }}</p>
                </div>
            </div>

            <div class="content">
                {{ $aJournal['notes'] }}
                <br>
                <small > {{ $aJournal['created_at']->diffForHumans() . ' - ' . $aJournal['created_at']->toFormattedDateString() }}</small>
            </div>
        </div>
    </div>

    @endforeach
</div>

{{ $aJournals->links('pagination.bulma') }} 

@else
<p class="nothing-more">
    Nothing to show.
</p>
@endif