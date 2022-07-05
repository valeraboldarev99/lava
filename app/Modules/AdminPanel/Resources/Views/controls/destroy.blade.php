<form action="{{ route($routePrefix . 'destroy', $entity->id) }}" method="POST" style="display: inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm js-delete">
        <i class="fa fa-fw fa-close delete"></i>
    </button>
</form>