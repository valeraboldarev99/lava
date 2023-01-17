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

@if (session()->has('message'))
    <div class="alert alert-info">{{ session('message') }}</div>
@endif

@if (session()->has('success'))
    <div class="alert alert-info">{{ session('success') }}</div>
@endif