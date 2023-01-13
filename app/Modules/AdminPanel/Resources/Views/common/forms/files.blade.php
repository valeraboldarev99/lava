{{-- <div class="col-md-12">
    @include('AdminPanel::common.forms.files', [
        'field' => 'multi_files',
        'label' => 'Мультизагрузка файлов',
        'helptext' =>  trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
    ])
</div> --}}

@push('js')
    <script>
        function addFile()
        {
           if($('#{{ $field }}').val() != '')
           {
                uploadFile();
           }
           else {
                alert('{!! trans('AdminPanel::adminpanel.in_first_check_file') !!}');
           }
        }

        function uploadFile()
        {
            const file = document.getElementById('{{ $field }}').files[0];
            var form_data = new FormData();
            form_data.append('field', '{{$field}}');
            form_data.append('entity_id', '{{$entity->id}}');
            form_data.append('{{$field}}', file);
            form_data.append('saved_name', $('#saved_name').val());
            form_data.append('_token', '{{csrf_token()}}');
            $('#loading__multi-files').css('display', 'inline-block');

            $.ajax({
                url: "{!! route($routePrefix . 'multiUploader') !!}",
                data: form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    // console.log(data);
                    $('#saved_name').val('');
                    $('#{{ $field }}').val('');

                    fileBlock(data);
                    $('#loading__multi-files').css('display', 'none');
                },
                error: function (xhr, status, error) {
                    alert('ERROR');
                    // alert(xhr.responseText);
                }
            });
        }

        function fileBlock(data)
        {
            $('#files-list__items').append('<div id="' + data.block_id + '" class="files-list__item"></div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__name">' + data.saved_name + '</div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__size">' + data.format + '</div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__size">' + data.file_size + '</div>');
            $('#' + data.block_id + '').append('<div class="files-list__block files-list__controls"> \n' +
                '<span class="btn btn-primary btn-sm" \n' +
                    'data-file_id="' + data.file_id + '" \n' +
                    'data-file_name="' + data.saved_name + '" \n' +
                    'onclick="changeFileNameForm.apply(this)"> \n' +
                    '<i class="fa fa-pencil"></i> \n' +
                '</span> \n' +
                '<a href="' + data.file_path + '" class="btn btn-primary btn-sm" target="_blank"> \n' +
                    '<i class="fa fa-arrow-down" aria-hidden="true"></i> \n' +
                '</a> \n' +
                '<span class="btn btn-danger btn-sm js-del-img" \n' +
                    'data-href="' + data.delete_route + '" \n' +
                    'data-file_id="' + data.file_id + '" \n' +
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
                        $('#loading__multi-files').css('display', 'inline-block');
                    },
                    success: function (data) {
                        // console.log(data);
                        $('#loading__multi-files').css('display', 'none');
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
            $('#multi-files__form-change').css('display', 'flex');
            $('#new_saved_name').val($(this).attr('data-file_name'));
            $('#changeFileName').attr('data-file_id', $(this).data('file_id'));
        }

        $('#changeFileName').on('click', function() {
            var update_form_data = new FormData();
            update_form_data.append('_token', '{{csrf_token()}}');
            update_form_data.append('field', '{{$field}}');
            update_form_data.append('entity_id', '{{$entity->id}}');
            update_form_data.append('file_id', $('#changeFileName').attr('data-file_id'));
            update_form_data.append('new_saved_name', $('#new_saved_name').val());
            $('#loading__multi-files_update').css('display', 'inline-block');

            $.ajax({
                url: "{!! route($routePrefix . 'changeFile') !!}",
                data: update_form_data,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (data) {
                    // console.log(data);
                    $('#' + data.block_id + ' .files-list__name').text(data.file.saved_name);
                    $('#loading__multi-files_update').css('display', 'none');
                    $('#multi-files__form-change').css('display', 'none');
                    $('#' + data.block_id + ' #changeFile').attr('data-file_name', data.file.saved_name);
                },
                error: function (xhr, status, error) {
                    alert('ERROR');
                    // alert(xhr.responseText);
                }
            });
        });

    </script>
@endpush

<label>{{ (isset($label)) ? $label : trans('AdminPanel::fields.multiupload_files') }}</label>
<div class="multi-files__field">
    @if(isset($entity->id))
        <div class="multi-files__form">
            <div class="multi-files__form-item">
                {!! MyForm::text('saved_name', trans('AdminPanel::fields.file_name')) !!}
            </div>
            <div class="multi-files__form-item">
                {!! MyForm::file($field, trans('AdminPanel::fields.check_file'), $entity->{$field}) !!}
            </div>
            <div class="multi-files__form-item">
                <span class="btn btn-success mt_25" onclick="addFile()">{{__('AdminPanel::adminpanel.buttons.upload_files')}}</span>
                <i id="loading__multi-files" class="fa fa-spinner fa-spin fa-2x fa-fw loading__multi-images"></i>
            </div>
        </div>
        @if(isset($helptext))
            {!! MyForm::helpText($helptext) !!}
        @endif
        <div id="multi-files__form-change" class="multi-files__form-change">
            <div class="multi-files__form-item">
                {!! MyForm::text('new_saved_name', trans('AdminPanel::fields.file_name')) !!}
            </div>

            <div class="multi-files__form-item">
                <span id="changeFileName" class="btn btn-success mt_25">{{__('AdminPanel::adminpanel.buttons.change')}}</span>
                <i id="loading__multi-files_update" class="fa fa-spinner fa-spin fa-2x fa-fw loading__multi-images"></i>
            </div>
        </div>
        <div id="files-list__items" class="files-list__items">
            @if($entity->files()->count())
                <div class="files-list__item">
                    <div class="files-list__block files-list__name">{{ __('AdminPanel::fields.file_name') }}</div>
                    <div class="files-list__block files-list__size">{{ __('AdminPanel::fields.format') }}</div>
                    <div class="files-list__block files-list__size">{{ __('AdminPanel::fields.size') }}</div>
                    <div class="files-list__block files-list__controls">{{ __('AdminPanel::adminpanel.controls') }}</div>
                </div>
                @foreach($entity->files()->get() as $file)
                    <div id="{{ $field . '_' . $entity->id . '_' . $file->id }}" class="files-list__item">
                        <div class="files-list__block files-list__name">{{ $file->saved_name }}</div>
                        <div class="files-list__block files-list__size">{{ $file->format }}</div>
                        <div class="files-list__block files-list__size">{{ $entity->getFileSize($file->file_size) }}</div>
                        <div class="files-list__block files-list__controls">
                            <span id="changeFile" class="btn btn-primary btn-sm" 
                                data-file_id="{{ $file->id }}"
                                data-file_name="{{$file->saved_name}}"
                                onclick="changeFileNameForm.apply(this)">
                                <i class="fa fa-pencil"></i>
                            </span>
                            <a href="{{$entity->getPathMultiFile($file->file_name, $field) }}" class="btn btn-primary btn-sm" target="_blank">
                                <i class="fa fa-arrow-down" aria-hidden="true"></i>
                            </a>
                            <span class="btn btn-danger btn-sm js-del-img"
                                data-href="{!! route($routePrefix . 'deleteMultiFiles', ['entity_id' => $entity->id, 'field' => $field, 'file_id' => $file->id]) !!}"
                                data-file_id="{{ $file->id }}"
                                onclick="deleteFile.apply(this)">
                                    <i class="fa fa-fw fa-close delete"></i>
                            </span>
                        </div>
                    </div>
                @endforeach
            @else
                <span id="js-no_images">{!! MyForm::helpText(trans('AdminPanel::adminpanel.no_files')) !!}</span>
            @endif
        </div>
    @else
        {!! MyForm::helpText(trans('AdminPanel::adminpanel.save_and_upload_files')) !!}
    @endif
</div>