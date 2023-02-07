{{-- @include('AdminPanel::common.forms.images', [
    'field' => 'multi_images',
    'label' => 'Мультизагрузка изображений',
    'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 500, 'h' => 200]),
    'show_img_size' => 'big',
    'images_method' => $entity->images1(),
]) --}}

@php
    if(!isset($show_img_size))
    {
        $show_img_size = NULL;
    }

    $images_method = isset($images_method) ? $images_method : $entity->images();
@endphp
@push('js')
    <script>
        function openFiles()
        {
           $('input[data-field="{{ $field }}"]').trigger('click');
        }
        $('#{{ $field }}').change(function () {
            if ($(this).val() != '') {
                uploadImg(this);
            }
        });
        function imageBlock(data)
        {
            $('#multi-images__items').append('<div id="' + data.block_id + '" class="multi-images__item"></div>');
            $('#' + data.block_id + '').append('<img src="' + data.file_path + '">');
            $('#' + data.block_id + '').append('<span   class="js-del-img del-img" \n' +
                'data-href="' + data.delete_route + '" \n' +
                'data-file_id="' + data.file_id + '" \n' +
                'onclick="deleteImage.apply(this)" \n' +
            '></span>');
            return true;
        }
        function uploadImg(img)
        {
            var form_data = new FormData();
            form_data.append('field', '{{$field}}');
            form_data.append('entity_id', '{{$entity->id}}');
            form_data.append('{{$field}}', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('show_img_size', '{{$show_img_size}}');
            $('#loading__multi-images').css('display', 'inline-block');
            $.ajax({
                url: "{!! route($routePrefix . 'multiUploader') !!}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    // console.log(data);
                    imageBlock(data);
                    $('#loading__multi-images').css('display', 'none');
                    if($('#js-no_images').css('display') == 'block')
                    {
                        $('#js-no_images').css('display', 'none');
                    }
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>

    <script>
        function deleteImage()
        {
            if (confirm("{{__('AdminPanel::adminpanel.delete_image_sure')}}"))
            {
                var image = $(this);
                var delete_form_data = new FormData();
                delete_form_data.append('entity_id', '{{ $entity->id }}');
                delete_form_data.append('field', '{{ $field }}');
                delete_form_data.append('file_id', $(this).data('file_id'));
                delete_form_data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(this).data('href'),
                    data: delete_form_data,
                    type: 'DELETE',
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#loading__multi-images').css('display', 'inline-block');
                    },
                    success: function (data) {
                        // console.log(data);
                        $('#loading__multi-images').css('display', 'none');
                        image.parent('.multi-images__item').remove();
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    },
                });
            }
        }
    </script>
@endpush
<label>{{ (isset($label)) ? $label : trans('AdminPanel::fields.multiupload_images') }}</label>
<div class="multi-images__field">
    @if(isset($entity->id))
        <div class="multi-images__form">
            {!! MyForm::file($field, '', $entity->{$field}, ['accept="image/*"', 'data-field="' . $field . '"']) !!}
            <span class="btn btn-success" style="margin-bottom: 15px;" onclick="openFiles()">{{__('AdminPanel::adminpanel.buttons.upload_images')}}</span>
            <i id="loading__multi-images" class="fa fa-spinner fa-spin fa-2x fa-fw" style="left: 200px;top: 50px;display: none"></i>
            @if(isset($helptext))
                {!! MyForm::helpText($helptext) !!}
            @endif
        </div>

        <div class="multi-images__items" id="multi-images__items">
            @if($images_method->count())
                @foreach($images_method->get() as $image)
                    <div id="{{ $field . '_' . $entity->id . '_' . $image->id }}" class="multi-images__item">
                        <img src="{{ $entity->getPathMultiImage($image->name, $field, $show_img_size) }}" alt="{{ $image->multi_images }}">
                        <span   class="js-del-img del-img" 
                                data-href="{!! route($routePrefix . 'deleteMultiFiles', ['entity_id' => $entity->id, 'field' => $field, 'file_id' => $image->id]) !!}"
                                data-file_id="{{ $image->id }}"
                                onclick="deleteImage.apply(this)">
                        </span>
                    </div>
                @endforeach
            @else
                <span id="js-no_images">{!! MyForm::helpText(trans('AdminPanel::adminpanel.no_images')) !!}</span>
            @endif
        </div>
    @else
        {!! MyForm::helpText(trans('AdminPanel::adminpanel.save_and_upload_image')) !!}
    @endif
</div>