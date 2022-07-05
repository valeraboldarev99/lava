@if (isset($routePrefix))
	@include('AdminPanel::controls.publish')
	@include('AdminPanel::controls.edit')
	@include('AdminPanel::controls.destroy')
@endif