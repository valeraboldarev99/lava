@if(isset($fields))
    @section('js')
    <script src="/adminpanel/bower_components/ckeditor4/ckeditor.js"></script>
        @foreach($fields as $field)
            @if (Schema::hasColumn(getTableName(), $field))
                <script>
                    CKEDITOR.replace( "{{ $field }}", {
                        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=',
                        removePlugins: ['exportpdf'],
                    } );
                </script>
            @endif
        @endforeach
    @endsection
@endif
