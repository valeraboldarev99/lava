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
                    console.log(data);
                    $('#loading__multi-files').css('display', 'none');
                },
                error: function (xhr, status, error) {
                    alert('ERROR');
                    // alert(xhr.responseText);
                }
            });
        }
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
                <span class="btn btn-success mt_25" onclick="addFile()">{{__('AdminPanel::adminpanel.upload_files')}}</span>
                <i id="loading__multi-files" class="fa fa-spinner fa-spin fa-2x fa-fw loading__multi-images"></i>
            </div>
        </div>
        @if(isset($helptext))
            {!! MyForm::helpText($helptext) !!}
        @endif
        <div class="files-list__items">
            @if($entity->files()->count())
                <div class="files-list__item">
                    <div class="files-list__block files-list__name">{{ __('AdminPanel::fields.file_name') }}</div>
                    <div class="files-list__block files-list__size">{{ __('AdminPanel::fields.format') }}</div>
                    <div class="files-list__block files-list__size">{{ __('AdminPanel::fields.size') }}</div>
                </div>
                @foreach($entity->files()->get() as $file)
                    <div class="files-list__item">
                        <div class="files-list__block files-list__name">{{ $file->saved_name }}</div>
                        <div class="files-list__block files-list__size">{{ $file->format }}</div>
                        <div class="files-list__block files-list__size">{{ $entity->getFileSize($file->file_size) }}</div>
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