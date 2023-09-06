<form action="{{ route('user.search') }}" method="GET">
    <div class="search__block">
        <div class="search__input_block">
            {!! MyForm::text('query', '',  isset($query) ? $query : NULL, ['placeholder="' . trans('Search::index.placeholder') . '"']) !!}
        </div>
        <div class="search__btn_block">
            {!! MyForm::button('submit', trans('Search::index.placeholder'), ['class="btn btn-default"']) !!}
        </div>
    </div>
</form>