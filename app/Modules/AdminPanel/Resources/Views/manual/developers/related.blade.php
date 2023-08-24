@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Добавление связанных записей в модуль</a></h1>
@endsection

@section('content')
    <h2>Связанные записи</h2>
    
    <p>Создайте новую таблицу для связанных записей</p>
    <p>Пример связанных новостей:</p>
    <pre>
        <code>
            &lt;?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            class CreateNewsRelatedTable extends Migration
            {
                public function up()
                {
                    Schema::create('news_related', function (Blueprint $table) {
                        $table->bigInteger('news_id')->unsigned();
                        $table->bigInteger('related_id')->unsigned();
                        $table->primary(['news_id','related_id']);
                    });
                }
                public function down()
                {
                    Schema::dropIfExists('news_related');
                }
            }
        </code>
    </pre>
    <p>В контроллере использовать <code>RelatedEntitues</code> и передать значение в объект <code>$relatedTable</code>:</p>
    <pre>
        <code>
            use App\Modules\AdminPanel\Http\Controllers\Other\RelatedEntities;
            class IndexController extends AdminMainController
            {
                use RelatedEntities;

                protected $relatedTable = [
                    'table' => 'news_related',
                    'main_table' => 'news',
                    'entity_id' => 'news_id'
                ];

                //...
            }
        </code>
    </pre>
    <p>Возможно нужно будет переопределить метод <code>after($..)</code>.</p>
    <p>Также в методах <code>store($..)</code> и <code>update($..)</code> после сохранения записать в сессию данные из <code>$request->all();</code></p>
    <pre>
        <code>
            session(['requestArray' => $request->all()]);
        </code>
    </pre>
    <p>В методе <code>edit($..)</code> передать во view <code>related_entities</code></p>
    <pre>
        <code>
            public function edit($id)
            {
                return view($this->getFormViewName(), [
                    //..
                    'related_entities' => $this->getEntityRelated($id),
                ]);
            }
        </code>
    </pre>
    <p>В форме подключить поле связанных записаей</p>
    <pre>
        <code>
            &#64;include('AdminPanel::common.forms.related_entities', [
                    'field' => 'related',
                    'routes' => $routePrefix . 'related',,
                    'label' => trans('AdminPanel::fields.related_entities'),
                    'helptext' => trans('AdminPanel::fields.help_related_entities'),
                ])
        </code>
    </pre>
    <p>В routes добавить route:</p>
    <pre>
        <code>
            Route::get('/your-model_related/related','IndexController@related')->name('your-model.related');
        </code>
    </pre>

@endsection