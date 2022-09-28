{{-- @include('AdminPanel::common.forms.image', [
    'field' => 'bg',
    'label' => 'Изображение bg',
    'helptext' => 'size 1920/780',
    'show_img_size' => 'big',
    'accept' => ['accept="image/*"'],
]) --}}
@php
    $imagePath = $entity->getImage($field, isset($show_img_size) ? $show_img_size : 'big');
@endphp
@push('js')
    <script>
        function deleteImage() {
            if (confirm("@lang('AdminPanel::adminpanel.delete_image_sure')")) {
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
        <label>{{  $label }}</label>

        <div class="image__block">
            <img src="{{ $imagePath }}">
            <span   class="del-img js-del-img" 
                    data-href="{!! route($routePrefix . 'deleteFile', ['id' => $entity->id, 'field' => $field]) !!}" 
                    data-csrf_token="{{ csrf_token() }}"
                    onclick="deleteImage.apply(this)">
            </span>
        </div>
        <div class="clearfix"></div>
    @else
        {!! MyForm::file($field, (isset($label)) ? $label : trans('AdminPanel::adminpanel.image') , $entity->image, isset($accept) ? $accept : ['accept="image/*"']) !!}
        @if(isset($helptext))
            {!! MyForm::helpText($helptext) !!}
        @endif
    @endif
</div>