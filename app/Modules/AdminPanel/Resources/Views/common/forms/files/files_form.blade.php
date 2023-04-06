<div class="multi-files__form">
    <div class="multi-files__form-item">
        <div class="form-group">
            <label for="saved_name_{{ $field }}">{{ __('AdminPanel::fields.file_name') }}</label>
            <input type="text" id="saved_name_{{ $field }}" class="form-control" name="saved_name" value="">
        </div>
    </div>
    <div class="multi-files__form-item">
        {!! MyForm::file($field, trans('AdminPanel::fields.check_file'), $entity->{$field}) !!}
    </div>
    <div class="multi-files__form-item">
        <span class="btn btn-success mt_25" data-input_id="{{ $field }}" onclick="addFile.apply(this)">{{__('AdminPanel::adminpanel.buttons.upload_files')}}</span>
        <i id="loading__multi-files-{{ $field }}" class="fa fa-spinner fa-spin fa-2x fa-fw loading__multi-images"></i>
    </div>
</div>
@if(isset($helptext))
    {!! MyForm::helpText($helptext) !!}
@endif