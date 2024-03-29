{{-- @include('AdminPanel::common.forms.image', [
    'field' => 'image',
    'label' => trans('AdminPanel::fields.image'),
    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 1920, 'h' => 780]),
    'show_img_size' => 'big',
    'accept' => ['accept="image/*"'],
]) --}}
@php
    $imagePath = $entity->getImagePath($field, isset($show_img_size) ? $show_img_size : null);
@endphp
@push('js')
    <script>
        function deleteSingleImage() {
            if (confirm("{{__('AdminPanel::adminpanel.delete_image_sure')}}")) {
                var xhr = new XMLHttpRequest();

                xhr.open('DELETE', $(this).attr('data-href'));
                xhr.setRequestHeader('X-CSRF-TOKEN', $(this).attr('data-csrf_token'));
                xhr.send();

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        location.reload();
                    }
                }
            }
        }
    </script>
@endpush

<div class="image__field">
    @if($imagePath)
        <label>{{ (isset($label)) ? $label : trans('AdminPanel::fields.image') }}</label>

        <div class="image__block">
            <img src="{{ $imagePath }}">
            <span   class="del-img" 
                    data-href="{!! route($routePrefix . 'deleteFile', ['id' => $entity->id, 'field' => $field]) !!}" 
                    data-csrf_token="{{ csrf_token() }}"
                    onclick="deleteSingleImage.apply(this)">
            </span>
            <a data-src="{{ $imagePath }}"
                data-fancybox
                class="open_image-gallery">
            </a>
        </div>
        <div class="clearfix"></div>
    @else
        {!! MyForm::file($field, (isset($label)) ? $label : trans('AdminPanel::fields.image') , $entity->{$field}, isset($accept) ? $accept : ['accept="image/*"']) !!}
        @if(isset($helptext))
            {!! MyForm::helpText($helptext) !!}
        @endif
    @endif
</div>