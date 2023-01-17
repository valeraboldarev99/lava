@if (isset($routePrefix))
    @include('AdminPanel::controls.list', ['routePrefix' => $routePrefix])
    @include('AdminPanel::controls.create', ['routePrefix' => $routePrefix])
@endif