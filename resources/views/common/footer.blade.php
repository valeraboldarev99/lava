<div class="page__footer">
    <footer class="footer">
        <div class="wrapper">
            <div class="footer__logo">
                <a href="{{ home() }}">
                    <img src="/img/logo3.png" alt="logo">
                </a>
            </div>
            <div class="footer__items">
                <div class="footer__item footer__item_info">
                    <h4 class="footer__item_header">@lang('index.info_header')</h4>
                    {!! getSetting('footer.info_links') !!}
                    <p class="copyright__text">&copy; {{ date('Y') }}, {{ getSetting('footer.copyright') }}</p>
                    <a href="mailto:work.valeriy99@gmail.com" class="dev_by" target="_blank">@lang('index.dev_by')</a>
                </div>

                <div class="footer__item footer__item_contacts">
                    <h4 class="footer__item_header">@lang('index.contact_header')</h4>
                    <div class="header__social">
                       @include('common.social')
                    </div>

                    <div class="footer__contacts_items">
                        @if(getSetting('phone_number'))
                            <div class="footer__contacts_item">
                                <a href="tel:{!! preg_replace('/\D+/', '', getSetting('phone_number')) !!}" class="footer__contacts_link footer__contacts_link-phone" target="_blank">
                                    {{ getSetting('phone_number') }}
                                </a>
                            </div>
                        @endif
                        @if(getSetting('contact.email'))
                            <div class="footer__contacts_item">
                                <a href="mailto:{{ getSetting('contact.email') }}" class="footer__contacts_link footer__contacts_link-email" target="_blank">
                                    {{ getSetting('contact.email') }}
                                </a>
                            </div>
                        @endif
                        @if(getSetting('contact.address_text') || getSetting('contact.address_link'))
                            <div class="footer__contacts_item">
                                <a href="{{ getSetting('contact.address_link') }}" class="footer__contacts_link footer__contacts_link-address" target="_blank">
                                    {!! getSetting('contact.address_text') !!}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="footer__item footer__item_menu">
                    @include('Structure::menu_footer')
                </div>
            </div>
        </div>
    </footer>
</div>
