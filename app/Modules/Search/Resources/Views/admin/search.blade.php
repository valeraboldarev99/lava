<form action="{{ route('admin.search') }}" method="GET">
    <div class="search__input_block">
        {!! MyForm::text('query', '',  isset($query) ? $query : NULL, ['placeholder="' . trans('Search::adminpanel.placeholder') . '"']) !!}
    </div>
    <div class="search__btn_block">
        {!! MyForm::button('submit','<i class="fa fa-search"></i>', ['class="btn btn-default"']) !!}
    </div>
</form>