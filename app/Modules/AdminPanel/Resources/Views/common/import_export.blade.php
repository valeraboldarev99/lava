@push('js')
    <script>
        $('.js-import').on('click', function() {
            if($('.js-import_form').css('display') == 'none')
            {
                $('.js-import_form').css('display', 'block');
            }
            else {
                $('.js-import_form').css('display', 'none');
            }
        });
    </script>
@endpush

@if (isset($routePrefix))
    <a class="btn btn-info" href="{!! route($routePrefix . 'export') !!}">
        <i class="fa fa-upload"></i> {{ __('AdminPanel::adminpanel.buttons.export')}}
    </a>
    <span class="js-import btn btn-info">
        <i class="fa fa-download"></i> {{ __('AdminPanel::adminpanel.buttons.import')}}
    </span>
    <div class="js-import_form import_form">
        {!! MyForm::open([
            'action' => $routePrefix . 'import',
            'method' => 'POST',
            'files' => true]) !!}

            <div class="row">
                <div class="col-md-4">
                    {!! MyForm::file('import_file', '') !!}
                </div>

                <div class="col-md-2">
                    {!! MyForm::submit(trans('AdminPanel::adminpanel.buttons.to_import')) !!}
                </div>
            </div>

        {!! MyForm::close() !!}
    </div>
@endif