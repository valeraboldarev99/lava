{{-- <div class="col-md-12">
    @include('AdminPanel::common.forms.files.files', [
        'field' => 'multi_files',
        'label' => 'Мультизагрузка файлов',
        'helptext' =>  trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
        'files_method' => $entity->files(),
    ])
</div> --}}

@push('js')
    <script>
        function addFile()
        {
            var field = $(this).attr('data-input_id');
            if($('#' + field +'').val() != '')
            {
                uploadFile(field);
            }
            else {
                alert('{!! trans('AdminPanel::adminpanel.in_first_check_file') !!}');
            }
        }

        function uploadFile(field)
        {
            const file = document.getElementById(field).files[0];
            var form_data = new FormData();
            form_data.append('field', field);
            form_data.append('entity_id', '{{$entity->id}}');
            form_data.append('' + field + '', file);
            form_data.append('saved_name', $('#saved_name_'+field).val());
            form_data.append('_token', '{{csrf_token()}}');
            $('#loading__multi-files-'+field).css('display', 'inline-block');

            $.ajax({
                url: "{!! route($routePrefix . 'multiUploader') !!}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    //console.log(data);
                    $('#saved_name_'+field).val('');
                    $('#'+field+'').val('');

                    fileBlock(data, field);
                    $('#loading__multi-files-'+field).css('display', 'none');
                },
                error: function (xhr, status, error) {
                    alert('ERROR');
                    // alert(xhr.responseText);
                }
            });
        }

        function fileBlock(data, field)
        {
            $('.js-files_list__items-'+field).append('<div id="' + data.block_id + '" class="files-list__item"></div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__name">' + data.saved_name + '</div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__size">' + data.format + '</div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__size">' + data.file_size + '</div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__controls" style="text-align: center;">' + '{{ __("AdminPanel::adminpanel.messages.update_page") }}' + '</div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__controls"> \n' +
                '<span class="btn btn-primary btn-sm" \n' +
                    'id="changeFile" \n' +
                    'data-file_field="' + field + '" \n' +
                    'data-file_id="' + data.file_id + '" \n' +
                    'data-file_name="' + data.saved_name + '" \n' +
                    'onclick="changeFileNameForm.apply(this)"> \n' +
                    '<i class="fa fa-pencil"></i> \n' +
                '</span> \n' +
                '<a href="' + data.file_path + '" download class="btn btn-primary btn-sm" target="_blank"> \n' +
                    '<i class="fa fa-arrow-down" aria-hidden="true"></i> \n' +
                '</a> \n' +
                '<span class="btn btn-danger btn-sm js-del-img" \n' +
                    'data-href="' + data.delete_route + '" \n' +
                    'data-file_id="' + data.file_id + '" \n' +
                    'data-file_field="' + field + '" \n' +
                    'onclick="deleteFile.apply(this)"> \n' +
                        '<i class="fa fa-fw fa-close delete"></i> \n' +
                '</span> \n' +
            '</div>');

            return true;
        }
    </script>

    <script>
        function deleteFile()
        {
            if (confirm("{{__('AdminPanel::adminpanel.delete_image_sure')}}"))
            {
                var file = $(this);
                var field = $(this).data('file_field');
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
                        $('#loading__multi-files-'+field).css('display', 'inline-block');
                    },
                    success: function (data) {
                        // console.log(data);
                        $('#loading__multi-files-'+field).css('display', 'none');
                        file.parent('.files-list__controls').parent('.files-list__item').remove();
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    },
                });
            }
        }
    </script>

    <script>
        function changeFileNameForm()
        {
            var field = $(this).data('file_field');            
            document.getElementById('multi-files__form-change multi-files__form-change-'+field).scrollIntoView();
            $('.multi-files__form-change-'+ field).css('display', 'flex');
            $('.multi-files__form-change-'+ field + ' #new_saved_name_'+field).val($(this).attr('data-file_name'));
            $('.multi-files__form-change-'+ field + ' #changeFileName-'+field).attr('data-file_id', $(this).data('file_id'));
        }

        function changeFileName()
        {
            var field = $(this).data('file_field');            
            if($('#new_saved_name_' + field +'').val() != '')
            {
                var update_form_data = new FormData();
                update_form_data.append('_token', '{{csrf_token()}}');
                update_form_data.append('field', field);
                update_form_data.append('entity_id', '{{$entity->id}}');
                update_form_data.append('file_id', $('#changeFileName-'+field).attr('data-file_id'));
                update_form_data.append('new_saved_name', $('#new_saved_name_'+field).val());
                
                $('#loading__multi-files_update-'+field).css('display', 'inline-block');

                $.ajax({
                    url: "{!! route($routePrefix . 'changeFile') !!}",
                    data: update_form_data,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        $('#' + data.block_id + ' .files-list__name').text(data.file.saved_name);
                        $('#loading__multi-files_update-'+field).css('display', 'none');
                        $('.multi-files__form-change-'+ field).css('display', 'none');
                        $('#' + data.block_id + ' #changeFile').attr('data-file_name', data.file.saved_name);
                    },
                    error: function (xhr, status, error) {
                        alert('ERROR');
                        // alert(xhr.responseText);
                    }
                });
            }
            else {
                alert("{!! trans('AdminPanel::adminpanel.in_first_input_name') !!}");
            }
        }
    </script>
@endpush

@php
    $files_method = isset($files_method) ? $files_method : $entity->files();
@endphp

<label>{{ (isset($label)) ? $label : trans('AdminPanel::fields.multiupload_files') }}</label>
<div class="multi-files__field">
    @if(isset($entity->id))
        @include('AdminPanel::common.forms.files.files_form')

        @include('AdminPanel::common.forms.files.files_form_change')

        @include('AdminPanel::common.forms.files.files_items')
    @else
        {!! MyForm::helpText(trans('AdminPanel::adminpanel.save_and_upload_files')) !!}
    @endif
</div>