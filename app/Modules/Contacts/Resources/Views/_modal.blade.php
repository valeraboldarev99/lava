<form action="{!! route('contacts.modalForm') !!}" method="post" class="js-call-form order__form">
    @csrf
    <input 
        type="text"
        name="name"
        class="form__input"
        value="{{ isset($old) ? $old['name'] : '' }}"
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
        value="{{ isset($old) ? $old['email'] : '' }}"
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
        value="{{ isset($old) ? $old['phone'] : '' }}"
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
    >{{ isset($old) ? $old['message'] : '' }}</textarea>
    @if ($errors->has('message'))
        <div class="form-error">
            {{ $errors->first('message') }}
        </div>
    @endif

    <div>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <div id="modal_recaptcha" class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
        @if ($errors->has('g-recaptcha-response'))
            <div class="form-error">
                {{ $errors->first('g-recaptcha-response') }}
            </div>
        @endif
    </div>

    <div class="contact__btn">
        <button id="js_call_submit" class="btn btn-success">@lang('Contacts::index.send')</button>
    </div>   
</form>