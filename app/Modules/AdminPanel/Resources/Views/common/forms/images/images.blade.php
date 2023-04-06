{{-- @include('AdminPanel::common.forms.images.images', [
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
            var field = $(this).attr('data-field');
            $('input[data-field="' + field + '"]').trigger('click');
        }
        $('#{{ $field }}').change(function () {
            if ($('#{{ $field }}').val() != '') {
                uploadImg(this);
            }
        });
        function imageBlock(data, field)
        {
            $('.js-multi-images__items-'+field).append('<div id="' + data.block_id + '" class="multi-images__item"></div>');
            $('#' + data.block_id + '').append('<img src="' + data.file_path + '">');
            $('#' + data.block_id + '').append('<span   class="js-del-img del-img" \n' +
                'data-href="' + data.delete_route + '" \n' +
                'data-file_id="' + data.file_id + '" \n' +  
                'data-field="' + field + '" \n' +  
                'onclick="deleteImage.apply(this)" \n' +
            '></span>');
            return true;
        }
        function uploadImg(img)
        {
            var field = $(img).attr('data-field');
            var size = $(img).attr('data-size');

            var form_data = new FormData();
            form_data.append('field', field);
            form_data.append('entity_id', '{{$entity->id}}');
            form_data.append('' + field + '', img.files[0]);
            form_data.append('_token', '{{csrf_token()}}');
            form_data.append('show_img_size', size);
            $('#loading__multi-images-'+field).css('display', 'inline-block');

            $.ajax({
                url: "{!! route($routePrefix . 'multiUploader') !!}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    //console.log(data);
                    imageBlock(data, field);
                    $('#loading__multi-images-'+field).css('display', 'none');
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
                var field = $(this).data('field');
                var delete_form_data = new FormData();
                delete_form_data.append('entity_id', '{{ $entity->id }}');
                delete_form_data.append('field', field);
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
                        $('#loading__multi-images-'+field).css('display', 'inline-block');
                    },
                    success: function (data) {
                        // console.log(data);
                        $('#loading__multi-images-'+field).css('display', 'none');
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
<div id="{{ $field . '_' . $entity->id }}" class="multi-images__field">
    @if(isset($entity->id))
        @include('AdminPanel::common.forms.images.images_form')
        
        @include('AdminPanel::common.forms.images.images_items')
    @else
        {!! MyForm::helpText(trans('AdminPanel::adminpanel.save_and_upload_image')) !!}
    @endif
</div>