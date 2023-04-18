'use strict';

document.addEventListener('DOMContentLoaded', function () {
    // Open call modals
    (function () {
        var $buttons = document.querySelectorAll('.js-call-button');

        for (var i = 0; i < $buttons.length; i++) {
            $buttons[i].addEventListener('click', openModal);
        }

        function openModal() {
            $.fancybox.open({
                src: this.getAttribute('data-src'),
                type: 'ajax',
                opts: {
                    afterLoad : function() {
                        callModal.init();
                    }
                },
            });
        }
    })();

    // Call modals
    var callModal = (function () {
        var $form;
        var $container;
        
        function init() {
            setElements();

            if ($form && $container) {
                setEvents();
            }

        }

        function setElements() {
            $form = document.querySelector('.js-call-form');
            $container = document.querySelector('#js_call_view');
        }

        function setEvents() {
            $form.removeEventListener('submit', onFormSubmit);
            $form.addEventListener('submit', onFormSubmit);
        }

        function onFormSubmit(event) {
            event.preventDefault()

            var xhr = new XMLHttpRequest();
            var route = $form.getAttribute('action');

            var formData = new FormData($form);
            // formData.append('g-recaptcha-response', grecaptcha.getResponse());

            xhr.open('POST', route, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);

            xhr.onload = () => {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        var data = JSON.parse(xhr.responseText);

                        if (data.state == 'error') {
                            onError(data);
                        } else {
                            onSuccess(data);
                        }
                    } else {
                        console.log(xhr.responseText);
                    }
                }
            }
        }

        function onError(data) {
            $container.innerHTML = data.view;

            // grecaptcha.render('call_form_recaptcha', {
            //     'sitekey': document.querySelector('#call_form_recaptcha').getAttribute('data-sitekey'),
            // });

            init();
        }

        function onSuccess(data) {
            $container.innerHTML = data.message;

            setTimeout(function() {
                $.fancybox.close();
            }, 5000);
        }

        return {
            init: init,
        }
    })();
});
