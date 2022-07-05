<form action="{{ route($routePrefix . 'destroy', $entity->id) }}" method="POST" style="display: inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-default js-delete">
        <i class="fa fa-fw fa-close text-danger delete"></i>
    </button>
</form>