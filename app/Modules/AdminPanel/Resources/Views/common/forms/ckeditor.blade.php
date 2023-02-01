@if(isset($fields))
    @section('js')
    <script src="/adminpanel/bower_components/ckeditor4/ckeditor.js"></script>
        @foreach($fields as $field)
                <script>
                    CKEDITOR.replace( "{{ $field }}", {
                        filebrowserBrowseUrl: '/ckfinder/browser',
                        removePlugins: ['exportpdf'],
                    } );
                </script>
        @endforeach
    @endsection
@endif
