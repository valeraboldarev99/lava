<div id="multi-files__form-change multi-files__form-change-{{$field}}" class="multi-files__form-change multi-files__form-change-{{$field}}">
    <div class="multi-files__form-item">
        <div class="form-group">
            <label for="new_saved_name_{{ $field }}">{{ __('AdminPanel::fields.file_name') }}</label>
            <input type="text" id="new_saved_name_{{ $field }}" class="form-control" name="new_saved_name" value="">
        </div>
    </div>

    <div class="multi-files__form-item">
        <span 
            id="changeFileName-{{ $field }}"
            class="btn btn-success mt_25"
            data-file_field="{{$field}}"
            onclick="changeFileName.apply(this)">
                {{__('AdminPanel::adminpanel.buttons.change')}}
            </span>
        <i id="loading__multi-files_update-{{ $field }}" class="fa fa-spinner fa-spin fa-2x fa-fw loading__multi-images"></i>
    </div>
</div>