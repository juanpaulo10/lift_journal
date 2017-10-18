<nav class="tabs is-boxed is-fullwidth">
    <div class="container">
        <ul>
            {{--  {{ App\Helpers::statusBadgeColor($oTask->status) }}  --}}
            <li class="{{ App\Helpers::isActive('/') }}">
                <a href="{{ App\Helpers::isCurrPage('/') }}">Journals</a>
            </li>
        </ul>
    </div>
</nav>