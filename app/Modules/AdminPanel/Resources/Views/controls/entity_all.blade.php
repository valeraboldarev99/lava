@if (isset($routePrefix))
	@include('AdminPanel::controls.edit')
	@include('AdminPanel::controls.destroy')
@endif