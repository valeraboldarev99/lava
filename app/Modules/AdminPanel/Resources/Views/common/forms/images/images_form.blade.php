<div class="multi-images__form">
    <div class="form-group">
        <input
            type="file"
            id="{{ $field }}"
            class="form-control"
            name="{{ $field }}"
            value=""
            accept="image/*"
            data-field="{{ $field }}"
            data-size="{{ $show_img_size ? $show_img_size : NULL }}"
        >
    </div>
    <span class="btn btn-success" style="margin-bottom: 15px;"  data-field="{{ $field }}" onclick="openFiles.apply(this)">{{__('AdminPanel::adminpanel.buttons.upload_images')}}</span>
    <i id="loading__multi-images-{{ $field }}" class="fa fa-spinner fa-spin fa-2x fa-fw" style="left: 200px;top: 50px;display: none"></i>
    @if(isset($helptext))
        {!! MyForm::helpText($helptext) !!}
    @endif
</div>