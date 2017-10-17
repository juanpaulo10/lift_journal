<nav class="tabs is-boxed is-fullwidth">
    <div class="container">
        <ul>
            {{--  {{ App\Helpers::statusBadgeColor($oTask->status) }}  --}}
            <li> <a></a> </li>
            <li class="{{ App\Helpers::isActive('/') }}">
                <a href="{{ App\Helpers::isCurrPage('/') }}">Journals</a>
            </li>
            <li class="{{ App\Helpers::isActive('/modifiers') }}"><a>Modifiers</a></li>
            <li><a>Grid</a></li>
            <li><a>Elements</a></li>
            <li><a>Components</a></li>
            <li><a>Layout</a></li>
        </ul>
    </div>
</nav>