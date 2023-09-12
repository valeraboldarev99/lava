{{-- @include('AdminPanel::common.forms.file', [
    'field' => 'file',
    'label' => 'trans('AdminPanel::fields.file'),
    'helptext' => trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
]) --}}

@push('js')
    <script>
        function deleteSingleFile() {
            if (confirm("{{__('AdminPanel::adminpanel.delete_file_sure')}}")) {
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

<div class="file__field">
    @if($entity->{$field})
        <label>{{ (isset($label)) ? $label : trans('AdminPanel::fields.file') }}</label>
        <div class="file__block">
            <span class="file__name">{{ $entity->getFileName($field, $size = true) }}</span>

            <a href="{{ route($routePrefix . 'downloadFile', ['id' => $entity->id, 'field' => $field]) }}" class="download-file"></a>
            <span   class="del-file" 
                    data-href="{!! route($routePrefix . 'deleteFile', ['id' => $entity->id, 'field' => $field]) !!}" 
                    data-csrf_token="{{ csrf_token() }}"
                    onclick="deleteSingleFile.apply(this)">
            </span>
        </div>
        <div class="clearfix"></div>
    @else
        {!! MyForm::file($field, (isset($label)) ? $label : trans('AdminPanel::fields.file') , $entity->{$field}) !!}
        @if(isset($helptext))
            {!! MyForm::helpText($helptext) !!}
        @endif
    @endif
</div>