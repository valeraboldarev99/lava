@if (isset($routePrefix))
    <a class="btn btn-info" href="{!! route($routePrefix . 'export') !!}">
        <i class="fa fa-upload"></i> {{ __('AdminPanel::adminpanel.buttons.export')}}
    </a>
    <a class="btn btn-info" href="{!! route($routePrefix . 'import') !!}">
        <i class="fa fa-download"></i> {{ __('AdminPanel::adminpanel.buttons.import')}}
    </a>
@endif