<nav class="tabs is-boxed is-fullwidth">
    <div class="container">
        <ul>
            {{--  {{ App\Helpers::statusBadgeColor($oTask->status) }}  --}}
            <li class="{{ App\Helpers::isActive('/') }}">
                <a href="{{ App\Helpers::isCurrPage('/') }}">Journals</a>
            </li>
            <li class="{{ App\Helpers::isActive('filter') }}">
                <a href="{{ App\Helpers::isCurrPage('filter') }}">Filter</a>
            </li>
            <li class="{{ App\Helpers::isActive('about') }}">
                <a href="{{ App\Helpers::isCurrPage('about') }}">About</a>
            </li>
        </ul>
    </div>
</nav>