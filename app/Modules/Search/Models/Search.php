<?php declare(strict_types=1);

namespace  App\Modules\Search\Models;

use Illuminate\Support\Facades\Facade;

/**
 * documention: https://github.com/protonemedia/laravel-cross-eloquent-search/tree/master;
 * 
 * @method static \ App\Modules\Search\Models\Searcher new()
 * @method static \ App\Modules\Search\Models\Searcher orderByAsc()
 * @method static \ App\Modules\Search\Models\Searcher orderByDesc()
 * @method static \ App\Modules\Search\Models\Searcher dontParseTerm()
 * @method static \ App\Modules\Search\Models\Searcher includeModelType()
 * @method static \ App\Modules\Search\Models\Searcher beginWithWildcard(bool $state)
 * @method static \ App\Modules\Search\Models\Searcher endWithWildcard(bool $state)
 * @method static \ App\Modules\Search\Models\Searcher soundsLike(bool $state)
 * @method static \ App\Modules\Search\Models\Searcher add($query, $columns, string $orderByColumn = null)
 * @method static \ App\Modules\Search\Models\Searcher when($value, callable $callback = null, callable $default = null)
 * @method static \ App\Modules\Search\Models\Searcher addMany($queries)
 * @method static \ App\Modules\Search\Models\Searcher paginate($perPage = 15, $pageName = 'page', $page = null)
 * @method static \ App\Modules\Search\Models\Searcher simplePaginate($perPage = 15, $pageName = 'page', $page = null)
 * @method static \Illuminate\Support\Collection parseTerms(string $terms, callable $callback = null)
 * @method static \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator get(string $terms = null)
 *
 * @see \ App\Modules\Search\Models\Searcher
 */
class Search extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-search';
    }
}
