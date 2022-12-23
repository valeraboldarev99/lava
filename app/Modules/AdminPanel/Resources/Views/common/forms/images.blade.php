{{-- @include('AdminPanel::common.forms.images', [
    'field' => 'multi_images',
    'label' => 'Мультизагрузка изображений',
    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 500, 'h' => 200]),
    'show_img_size' => 'big',
]) --}}

@php
    if(!isset($show_img_size))
    {
        $show_img_size = NULL;
    }
@endphp
@push('js')
    <script>
        function openFiles()
        {
           $('input[data-id="{{ $field }}"]').trigger('click');
        }
        $(document).ready(function(){
            $('input[data-id="{{ $field }}"]').on('change', function() {
                $('button[type="submit"]').trigger('click');
                $.ajax({
                    route: 'card/update-count/' + itemId + '/' + count,
                    method: 'get',
                    success: function(data) {
                        location.reload();
                    }
                });
            });
        });
    </script>

    <script>
        function deleteImagess() {
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
<div class="multi-images__field">
    <div class="multi-images__form">
        {!! MyForm::file($field . '[]', (isset($label)) ? $label : trans('AdminPanel::fields.file'), $entity->{$field}, ['multiple', 'accept="image/*"', 'data-id="' . $field . '"']) !!}
        <span class="btn btn-success" style="margin-bottom: 15px;" onclick="openFiles()">Select File</span>
        @if(isset($helptext))
            {!! MyForm::helpText($helptext) !!}
        @endif
    </div>

    @if($entity->images()->count())
        <div class="multi-images__items">
            @foreach($entity->images()->get() as $image)
                <div class="multi-images__item">
                    <img src="{{ $entity->getPathMultiImage($image->name, $field, $show_img_size) }}" alt="{{ $image->multi_images }}">
                    <span   class="del-img" 
                            data-href="{!! route($routePrefix . 'deleteMultiImages', ['entity_id' => $entity->id, 'field' => $field, 'image_id' => $image->id]) !!}" 
                            data-csrf_token="{{ csrf_token() }}"
                            onclick="deleteImagess.apply(this)">
                    </span>
                </div>
            @endforeach
        </div>
    @else
        @lang('AdminPanel::adminpanel.no_images')
    @endif
</div>