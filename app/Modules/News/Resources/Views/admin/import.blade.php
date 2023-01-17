{{-- @extends('AdminPanel::admin.index') --}}

<form action="{{ route($routePrefix . 'import')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="imprt_file">
    <button type="submit">Submit</button>
</form>