{{-- <div class="col-md-6">
	@include('AdminPanel::common.forms.choose_file_from_server', [
		'field_name'    => 'field_namer',
		'label'         => 'Files',
		'helptext'      => trans('AdminPanel::fields.help_for_browsefile'),
		'value'         => $entity->title,
	])
</div> --}}

@push('js')
	<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
	<script>
		var route_prefix = "/laravel-filemanager";
		$('#lfm-{{ $field_name }}').filemanager('file', {prefix: route_prefix});
	</script>
@endpush

<div class="form-group">
	<label for="{{ $field_name }}">{{ (isset($label)) ? $label : trans('AdminPanel::fields.file') }}</label>
	<div class="choose__item">
		<input type="text" id="{{ $field_name }}" class="form-control choose__item_input" name="{{ $field_name }}" value="{{ $value }}">
		<span id="lfm-{{ $field_name }}" class="btn btn-primary btn_choose" data-input="{{ $field_name }}">
			<i class="fa fa-files-o"></i> {{ __('AdminPanel::fields.choose') }}
		</span>
	</div>
</div>
@if(isset($helptext))
	{!! MyForm::helpText($helptext) !!}
@endif