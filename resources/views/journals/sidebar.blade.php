{{--  :monthly-workouts=' {!! json_encode($aMonthlyWorkouts) !!} '  --}}
<div>
    <p class="menu-label is-size-6 sidebar-label">
        <span>MONTHLY WORKOUTS</span>
    </p>
    
    
    <ul class="menu-list is-size-7">
    @foreach( $aMonthlyWorkouts as $aStats )
        <li>
            <a href="/filter?month={{ $aStats['month'] }}&year={{ $aStats['year'] }}"
                class="{{ App\Helpers::isActiveFull ( request()->url() . '?month=' . $aStats['month'] . '&year=' . $aStats['year']) }}"
                >
                {{ $aStats['month'] . ' ' . $aStats['year'] }}
            </a>
        </li>
    @endforeach
    </ul>

</div>