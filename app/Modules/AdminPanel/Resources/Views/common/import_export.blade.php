@if (isset($routePrefix))
    <a class="btn btn-info" href="{!! route($routePrefix . 'export') !!}">
        <i class="fa fa-upload"></i> {{ __('AdminPanel::adminpanel.buttons.export')}}
    </a>
    <a class="btn btn-info" href="{!! route($routePrefix . 'importview') !!}">
        <i class="fa fa-download"></i> {{ __('AdminPanel::adminpanel.buttons.import')}}
    </a>
    <div class="js-import_form import_form">
    	{!! MyForm::open([
    		'action' => $routePrefix . 'import',
    	    'method' => 'POST',
    	    'files' => true]) !!}

    	    <div class="row">
    	        <div class="col-md-6">
    	    		{!! MyForm::file('import_file', '') !!}
    	    	</div>

    	        <div class="col-md-6">
    	    		{!! MyForm::submit(trans('AdminPanel::adminpanel.buttons.import')) !!}
    	    	</div>

    	{!! MyForm::close() !!}
    </div>
@endif