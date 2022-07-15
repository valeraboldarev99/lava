<form action="{{ route($routePrefix . 'update', $entity->id) }}" method="POST" class="control__item">
	@csrf
	@method('PATCH')

	{!! MyForm::hidden('active', abs($entity->active - 1)) !!}
	<button type="submit" class="btn btn-sm @if($entity->active) btn-default  @else btn-warning @endif">
		<i class="@if($entity->active) fa fa-check text-success @else fa fa-eye-slash @endif"></i>
	</button>
</form>