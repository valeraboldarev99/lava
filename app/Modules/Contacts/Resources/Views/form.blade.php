@if (session()->has('message'))
    @lang('Contacts::index.success')
@else
form
    {{-- <form action="{{ route('contacts.store') }}" method="POST" class="order__form">
        {!! csrf_field() !!}

        <input 
            type="text"
            id="name"
            name="name"
            class="form__input"
            value="{{ old('name') }}"
            required
            placeholder="@lang('Contacts::index.name')"
        >
        @if ($errors->has('name'))
            <div class="form-error">
                {{ $errors->first('name') }}
            </div>
        @endif

        <input
            type="email"
            id="email"
            name="email"
            class="form__input"
            required="required"
            value="{{ old('email') }}"
            placeholder="@lang('Contacts::index.email')"
        >
        @if ($errors->has('email'))
            <div class="form-error">
                {{ $errors->first('email') }}
            </div>
        @endif
    
        <input
            type="text"
            id="phone"
            name="phone"
            class="form__input"
            required="required"
            value="{{ old('phone') }}"
            placeholder="@lang('Contacts::index.phone')"
        >
        @if ($errors->has('phone'))
            <div class="form-error">
                {{ $errors->first('phone') }}
            </div>
        @endif

        <textarea
            name="message"
            class="form__input order__form_textarea"
            required
            placeholder="@lang('Contacts::index.message')"
        >{{ old('message') }}</textarea>
        @if ($errors->has('message'))
            <div class="form-error">
                {{ $errors->first('message') }}
            </div>
        @endif

        <div>
            @include('common.recaptcha')
            @if ($errors->has('g-recaptcha-response'))
                <div class="form-error">
                    {{ $errors->first('g-recaptcha-response') }}
                </div>
            @endif
        </div>

        <div class="contact__btn">
            <button class="btn btn-success">@lang('Contacts::index.send')</button>
        </div>
    </form> --}}
@endif