@if (isset($routePrefix))
    <div class="header-controls">
        @include('AdminPanel::controls.list', ['routePrefix' => $routePrefix])
        @include('AdminPanel::controls.create', ['routePrefix' => $routePrefix])
    </div>
@endif