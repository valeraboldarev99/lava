@if (count($errors) > 0)
    <!-- Список ошибок формы -->
    <div class="alert alert-danger">
        <strong>{{__('AdminPanel::adminpanel.form_error')}}</strong>
        <br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('failures'))
    <div class="alert alert-danger">
        <strong>{{__('AdminPanel::adminpanel.import_error')}}</strong>
        <br><br>
        <ul>
            @foreach (session()->get('failures') as $errors)
                <li>
                    {{__('AdminPanel::adminpanel.line')}} {{ $errors->row() }}
                    @foreach($errors->errors() as $error)
                        {{$error}}
                    @endforeach
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('message'))
    <div class="alert alert-info">{{ session('message') }}</div>
@endif

@if (session()->has('success'))
    <div class="alert alert-info">{{ session('success') }}</div>
@endif