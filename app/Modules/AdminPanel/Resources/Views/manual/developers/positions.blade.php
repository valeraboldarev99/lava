@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Позиционирование</a></h1>
@endsection

@section('content')
    <h2>Добавление позиционирования сущностей в модуль</h2>
    <p>Позиционирование позволяет сортировать сущности в таблице, меняя позицию каждой сущности.</p>
    <p>На данный момент есть 2 вида позиционирования:</p>
    <ul>
        <li>
            Обычное позиционирование - сущности равнозначны между собой и не имеют структурной формы. <br>
            При изменении позиции сущности, позиция остальных сущностей остается не изменной. <br>
            Для корректной работы требуется сортировка по убыванию. <br>
            Вызывается метод: position.
        </li>
        <li>
            Структурное позиционирование - есть родительские и дочерние сущности. <br>
            При зменении позиции сущности, позиция остальных сущностей меняется. <br>
            Если у родительской сущности есть потомки, то при изменении позиции родителя изменится позиция всех потомков.
            При удалении сущности меняется позиция всех сущностей, у которых позиция была больше удаленной.
            При изменении позиции, сущность с которой меняются местами, тоже меняет позицию. <br>
            Для корректной работы требуется сортировка по возрастанию. <br>
            Вызывается метод: positionStructure.
        </li>
    </ul>
    <p>Для добавления в модуль выполните следующие простые шагам:</p>
    <ul>
        <li><a href="#DataBase">Настройка DataBase</a></li>
        <li><a href="#Controllers">Настройка Controllers</a></li>
        <li><a href="#Views">Настройка Views</a></li>
        <li><a href="#Routes">Настройка Routes</a></li>
    </ul>

    <h3 id="DataBase">1. В вашем модуле в папке DataBase/Migrations</h3>
    <p>Добавить поле:</p>
    <pre>
        <code>
            //..
            $table->integer('position')->nullable()->default(0);
            //..
        </code>
    </pre>

    <h3 id="Controllers">2. В вашем модуле в папке Http/Controllers/Admin:</h3>
    <p>Подключить Position</p>
    <p>Пример:</p>
    <pre>
        <code>
            &lt;?php
            namespace App\Modules\YourModel\Http\Controllers\Admin;

            use App\Modules\AdminPanel\Http\Controllers\Other\Position;

            class IndexController extends AdminMainController
            {
                use Position;

                //..
            }
        </code>
    </pre>
    <h3 id="Views">3. В вашем модуле в папке Views</h3>
    <p>В index файле где выводятся все сущности добавить:</p>
    <pre>
        <code>
            &#60;th width="130"&#62;&#123;&#123; __('AdminPanel::adminpanel.position') &#125;&#125;&#60;&#47;th&#62;
            
            //..

            //показывать позицию
            &#60;td&#62;
                &#64;include('AdminPanel::controls.position')
            &#60;&#47;td&#62;

            //не показывать позицию
            &#60;td&#62;
                &#64;include('AdminPanel::controls.position', ['showPosition' => false])
            &#60;&#47;td&#62;
        </code>
    </pre>

    <h3 id="Routes">4. В вашем модуле в папке Routes</h3>
    <p>Для обычного позиционирования:</p>
    <pre>
        <code>
            Route::post('/news/position/{id}/{direction}', 'IndexController@position')->name('news.position');
        </code>
    </pre>
    <p>Для структурного позиционирования, все тоже самое, только :</p>
    <pre>
        <code>
            Route::post('structure/position/{id}/{direction}', 'IndexController@positionStructure')->name('structure.position');
        </code>
    </pre>
    
@endsection