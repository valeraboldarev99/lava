@extends('AdminPanel::layouts.app')

@section('title')
    <h1>Как добавить изображения и файлы в модуль</h1>
@endsection

@section('content')
    <h2>Добавление возможности загрузки изображений и файлов модуль</h2>
    <br>
    <p>Функционал позволяет добавлять:</p>
    <ul>
        <li>Одиночные изображения</li>
        <li>Одиночные файлы</li>
        <li>Мультиизображения - когда в одно поле можно загрузить много картинок</li>
        <li>Мультифайлы&nbsp;- когда в одно поле можно загрузить много файлов</li>
    </ul>
    <p>Чтобы добавить загрузку выполните следующие простые шагам:</p>
    <ul>
        <li>
            <a href="#config">Настройка config</a>
        </li>
        <li>
            <a href="#DataBase">Настройка DataBase</a>
        </li>
        <li>
            <a href="#Controllers">Настройка Controllers</a>
        </li>
        <li>
            <a href="#Modules">Настройка Modules</a>
        </li>
        <li>
            <a href="#Views">Настройка Views</a>
        </li>
        <li>
            <a href="#Routes">Настройка Routes</a>
        </li>
    </ul>
    <br></br>
    <h3 id="config"><strong>1. В вашем модуле в папке Config создать файл uploads.php;</strong></h3>
    <pre>
        <code>
            &lt;?php
                return [
                    ///
                ];
        </code>
    </pre>
    <p>В этом файле будут описаны параметры для файлов и изображений</p>

    <p>Возможные парамерты и их значения приведены в таблице ниже.</p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Параметры</th>
                <th scope="col">Значения</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;path&#39;</code></p>
                </td>
                <td>
                <p>Путь к файлу, где его сохранить.</p>

                <p>Пример: <code>&#39;/uploads/products/img/&#39;</code>,</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;validator&#39;</code></p>
                </td>
                <td>
                <p>Валидация файлов при загрузке.</p>

                <p>Пример:<code>&#39;mimes:jpeg,jpg,png,pdf,mp3|max:10000&#39;</code></p>

                <p>mimes: - список допустимых форматов</p>

                <p>max: - максимальный размер файла</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;sizes&#39;</code></p>
                </td>
                <td>
                <p>Необязательно.</p>

                <p>Если необходимо чтобы изображения загружались сразу в нескольких размерах.</p>

                <p>Предаются названия размеров, обычно:<code>&#39;big&#39;, &#39;middle&#39;, &#39;small&#39;</code><span style="background-color:#bdc3c7">.</span></p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;webp&#39;</code></p>
                </td>
                <td>
                <p>Необязательно.</p>

                <p>Этот параметр передается внутри sizes, для каждого размера отдельно.</p>

                <p>Если указан этот параметр, то изображение будет конретировано в webp формат и сохранено вместе с обычным форматом.</p>

                <p>Имена у обоих форматов будут одинаковые.</p>

                <p>В качестве значения передется число <code>0-100</code> в каком качестве будет оно сохранено.</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;width&#39;</code></p>
                </td>
                <td>
                <p>Необязательно.</p>

                <p>Этот параметр передается внутри sizes, для каждого размера отдельно.</p>

                <p>Значение в пикселях для обрезки размеров.</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;height&#39;</code></p>
                </td>
                <td>
                <p>Необязательно.</p>

                <p>Этот параметр передается внутри sizes, для каждого размера отдельно.</p>

                <p>Значение в пикселях для обрезки размеров, но чаще всего передается <code>false</code></p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;field_name&#39;</code></p>
                </td>
                <td>
                <p>Для загрузки файлов. Сюда передается название поля в таблице БД в котором хранится имя файла.</p>

                <p>часто это&nbsp;<code>&#39;file_name&#39;</code>, но если у вас несколько таких колей то названия могут отличаться</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;field_size&#39;</code></p>
                </td>
                <td>
                <p>Для загрузки файлов. Сюда передается название поля в таблице БД в котором хранится размер файла.</p>

                <p>часто это&nbsp;<code>&#39;file_size&#39;</code>, но если у вас несколько таких колей то названия могут отличаться</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;multiple&#39;</code></p>
                </td>
                <td>
                <p>если это поле для мультизагрузки то нужно указать <code>true</code></p>

                <p>для обычной одиночной загрузки можно указать <code>false</code> или не писать этот параметр</p>
                </td>
            </tr>
            <tr>
                <td style="text-align:center">
                <p><code>&#39;save_type&#39;</code></p>
                </td>
                <td>
                <p>Используется при мультизагрузке.</p>

                <p>Значения:</p>

                <p><code>&#39;as_file&#39;</code> - при мультизагрузке файлов<br />
                <code>&#39;as_image&#39;</code> -&nbsp;при мультизагрузке картинок</p>
                </td>
            </tr>
        </tbody>
    </table>

    <br><br>
    <p>Пример для изображений:</p>
    <pre>
        <code>
            'image' => [                                            //название поля
                'path'      => '/uploads/news/img/',
                'validator' => 'mimes:jpeg,jpg,png|max:10000',
                'sizes'    => [
                    'big'  => [
                        'path'   => 'big/',
                        'webp'   => 60,
                        'width'  => 1920,
                        'height' => false,
                    ],
                    'middle' => [
                        'path'   => 'middle/',
                        'webp'   => 100,
                        'width'  => 760,
                        'height' => false,
                    ],
                    'small'  => [
                        'path'   => 'small/',
                        'webp'   => false,
                        'width'  => 375,
                        'height' => false,
                    ]
                ]
            ],
            'bg' => [                                            //название поля
                'path'      => '/uploads/products/bg/',
                'validator' => 'max:10000',
            ],
        </code>
    </pre>

    <p>Пример для файлов:</p>
    <pre>
        <code>
            'file' => [                                            //название поля
                'path'      => '/uploads/products/files/',
                'validator' => 'max:50000',
                'field_name' => 'file_name',
                'field_size' => 'file_size',
            ],
            'file2' => [                                            //название поля
                'path'      => '/uploads/products/files2/',
                'validator' => 'max:50000',
                'field_name' => 'file_name2',
                'field_size' => 'file_size2',
            ],
        </code>
    </pre>

    <p>Примеры мультизагрузки изображений:</p>
    <pre>
        <code>
            'products_multi_images1' => [
                'path'      => '/uploads/products/products_multi_images1/',
                'validator' => 'mimes:png|max:10000',
                'multiple'  => true,
                'save_type' => 'as_image',
                'field_name' => 'name',
                'sizes'    => [
                    'big'  => [
                        'path'   => 'big/',
                        'webp'   => 60,
                        'width'  => 500,
                        'height' => false,
                    ],
                    'small'  => [
                        'path'   => 'small/',
                        'webp'   => false,
                        'width'  => 375,
                        'height' => false,
                    ]
                ]
            ],
            'products_multi_images2' => [
                'path'      => '/uploads/products/products_multi_images2/',
                'validator' => 'mimes:png|max:10000',
                'multiple'  => true,
                'save_type' => 'as_image',
                'field_name' => 'name',
            ],
        </code>
    </pre>

    <p>Примеры мультизагрузки файлов:</p>
    <pre>
        <code>
            'products_multi_files1' => [
                'path'      => '/uploads/products/products_multi_files1/',
                'validator' => 'max:100000',
                'multiple'  => true,
                'save_type' => 'as_file',
                'field_name' => 'file_name',
                'field_size' => 'file_size',
            ],
            'products_multi_files2' => [
                'path'      => '/uploads/products/products_multi_files2/',
                'validator' => 'max:100000',
                'multiple'  => true,
                'save_type' => 'as_file',
                'field_name' => 'file_name',
                'field_size' => 'file_size',
            ],
        </code>
    </pre>

    <h3 id="DataBase"><strong>2. В вашем модуле в папке DataBase/Migrations:</strong></h3>
    <p>Для изображений и файлов одиночной загрузки в существующую таблицу добавить необходимые поля.</p>
    <p>Для изобрашений - поле для имени</p>
    <p>Для файлов - поле для имени, поле для реального ими и поле размера</p>
    <p>Примеры:</p>
    <pre>
        <code>
            //пример для картинки - с именем image
            $table->string('image')->nullable();

            //пример для картинки - с именем bg
            $table->string('bg')->nullable();

            //пример для файла - с именем file, с полями file_name и file_size
            $table->string('file')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();

            //пример для файла - с именем file2, с полями file_name2 и file_size2
            $table->string('file2')->nullable();
            $table->string('file_name2')->nullable();
            $table->string('file_size2')->nullable();
        </code>
    </pre>

    <p>При мультизагрузке файлов или изображений создается отдельная таблица, основная таблица остается без изменений</p>
    <p>Пример мультизагрузки изображений:</p>
    <pre>
        <code>
            &lt;?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;

            class CreateProductsImages1Table extends Migration
            {
                public function up()
                {
                    Schema::create('products_images1', function (Blueprint $table) {
                        $table->bigIncrements('id');
                        $table->string('name')->nullable();                                 //название сохраненной картинки
                        $table->integer('position')->nullable()->default(0);                //поле для сортировки картинок между собой
                        $table->bigInteger('parent_id')->unsigned();                        //ID родителя
                        $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');

                        $table->timestamps();
                    });
                }

                public function down()
                {
                    Schema::dropIfExists('products_images1');
                }
            }
        </code>
    </pre>

    <p>Пример мультизагрузки файлов:</p>
    <pre>
        <code>
            &lt;?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;

            class CreateProductsFiles1Table extends Migration
            {
                public function up()
                {
                    Schema::create('products_files1', function (Blueprint $table) {
                        $table->bigIncrements('id');
                        $table->string('saved_name')->nullable();                           //имя файла заданное пользователем
                        $table->string('file_name')->nullable();                            //сгенирированное имя
                        $table->string('file_size')->nullable();                            //размер файла
                        $table->string('format')->nullable();                               //формат файла
                        $table->integer('position')->nullable()->default(0);                //поле для сортировки файлов между собой
                        $table->bigInteger('parent_id')->unsigned();                        //ID родителя
                        $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');

                        $table->timestamps();
                    });
                }

                public function down()
                {
                    Schema::dropIfExists('products_files1');
                }
            }
        </code>
    </pre>
    <h3 id="Controllers"><strong>3. В вашем модуле в папке Http/Controllers/Admin:</strong></h3>
    <p>Используется при любой загрузке FileUploader</p>
    <p>Пример:</p>
    <pre>
        <code>
            &lt;?php
            namespace App\Modules\YourModel\Http\Controllers\Admin;

            //..
            use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;

            class IndexController extends Controller
            {
                use FileUploader;

                //..
            }
        </code>
    </pre>
    <h3 id="Modules"><strong>4. В вашем модуле в папке Models</strong></h3>
    <p>В родительской моделе вызвать модель FileUploader</p>
    <pre>
        <code>
            &lt;?php
            namespace App\Modules\YourModel\Models;

            //..
            use App\Modules\AdminPanel\Models\FileUploader;

            class YourModel extends Model {

                use FileUploader;
            }
        </code>
    </pre>
    <p>Если требуется мультизагрузка, то дополнительно прописать:</p>
    <pre>
        <code>
            protected $multipleFilesTables = [
                'table_name'              => 'field_name',
                
                //примеры
                'products_multi_images1'  => 'products_images1',
                'products_multi_files1'   => 'products_files1',
            ];

            //для получения products_images1
            //сортировка по возрастанитю обязательна!
            public function images1()
            {
                return $this->hasMany(ProductsImages1::class, 'parent_id', 'id')->orderBy('position', 'asc');
            }

            //для получения products_files1
            //сортировка по убыванию обязательна!
            public function files1()
            {
                return $this->hasMany(ProductsFiles1::class, 'parent_id', 'id')->orderBy('position', 'desc');
            }
        </code>
    </pre>

    <p>Модель для мультифайлов и мультиизображений выглядит так:</p>
    <pre>
        <code>
            &lt;?php
            namespace App\Modules\YourModel\Models;

            use Illuminate\Notifications\Notifiable;
            use App\Modules\AdminPanel\Models\Model;

            class YourModelImages1 extends Model {

                use Notifiable;

                protected $table = 'table_name';
            }
        </code>
    </pre>

    <h3 id="Views"><strong>5. В вашем модуле в папке Views</strong></h3>
    <p>Для одиноной загрузки картинок:</p>
    <p>Через include всавляем форму 'AdminPanel::common.forms.image' и передаем в нее параметры:</p>
    <ul>
        <li>'field' - название поля</li>
        <li>'label' - текст для label</li>
        <li>'helptext' - текст подсказка подформой загрузки, например форматы или рекомендуемый размер (необязательно)</li>
        <li>'show_img_size' - какой размер будет обображаться в форме админпанели (необязательно)</li>
        <li>'accept' - Устанавливает фильтр на типы файлов. По умолчанию: 'accept="image/*"'</li>
    </ul>
    <pre>
        <code>
            &#64;include('AdminPanel::common.forms.image', [
                'field' => 'image',
                'label' => trans('AdminPanel::fields.image'),
                'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 1920, 'h' => 780]),
                'show_img_size' => 'big',
                'accept' => ['accept="image/*"'],
            ])
        </code>
    </pre>
    
    <p>Для одиноной загрузки файлов:</p>
    <p>Через include всавляем форму 'AdminPanel::common.forms.file' и передаем в нее параметры:</p>
    <ul>
        <li>'field' - название поля</li>
        <li>'label' - текст для label</li>
        <li>'helptext' - текст подсказка подформой загрузки, например форматы или рекомендуемый размер (необязательно)</li>
    </ul>
    <pre>
        <code>
            &#64;include('AdminPanel::common.forms.file', [
                'field' => 'file',
                'label' => trans('AdminPanel::fields.file'),
                'helptext' => trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
            ])
        </code>
    </pre>

    <p>Для мультизагрузки файлов:</p>
    <p>Через include всавляем форму 'AdminPanel::common.forms.files.files' и передаем в нее параметры:</p>
    <ul>
        <li>'field' - название поля</li>
        <li>'label' - текст для label</li>
        <li>'helptext' - текст подсказка подформой загрузки, например форматы или рекомендуемый размер (необязательно)</li>
        <li>'files_method' - метод для получения записей этого поля</li>
    </ul>
    <pre>
        <code>
            &#64;include('AdminPanel::common.forms.files.files', [
                'field' => 'products_multi_files1',
                'label' => trans('AdminPanel::fields.multiupload_files'),
                'helptext' =>  trans('AdminPanel::fields.file_format', ['formats' => 'docx/doc']),
                'files_method' => $entity->files1(),
            ])
        </code>
    </pre>
    
    <p>Для мультизагрузки изображений:</p>
    <p>Через include всавляем форму 'AdminPanel::common.forms.images.images' и передаем в нее параметры:</p>
    <ul>
        <li>'field' - название поля</li>
        <li>'label' - текст для label</li>
        <li>'helptext' - текст подсказка подформой загрузки, например форматы или рекомендуемый размер (необязательно)</li>
        <li>'show_img_size' => какой размер будет обображаться в форме админпанели (необязательно)</li>
        <li>'files_method' - метод для получения записей этого поля</li>
    </ul>
    <pre>
        <code>
            &#64;include('AdminPanel::common.forms.images.images', [
                'field' => 'products_multi_images1',
                'label' => trans('AdminPanel::fields.multiupload_images'),
                'helptext' => trans('AdminPanel::fields.optimal_image_size', ['w' => 500, 'h' => 200]),
                'show_img_size' => 'big',
                'images_method' => $entity->images1(),
            ])
        </code>
    </pre>

    <h3 id="Routes"><strong>6. В вашем модуле в папке Routes</strong></h3>
    <p>Прописать пути:</p>
    <pre>
        <code>
            //для одиночной загрузки
            Route::delete('/your_model/deleteFile/{id}/{field}', 'IndexController@deleteFile')->name('your_model.deleteFile');
            Route::get('/your_model/download_file/{id}/{field}', 'IndexController@downloadFile')->name('your_model.downloadFile');
            
            //для мультизагрузки
            Route::delete('/your_model/deleteMultiFiles/{entity_id}/{field}/{file_id}', 'IndexController@deleteMultiFiles')->name('your_model.deleteMultiFiles');
            Route::post('/your_model/multi_uploader', 'IndexController@multiUploader')->name('your_model.multiUploader');
            Route::post('/your_model/change_file', 'IndexController@changeFile')->name('your_model.changeFile');
            Route::post('/your_model/file-position', 'IndexController@positionFile')->name('your_model.positionFiles');
            Route::post('/your_model/image-position', 'IndexController@positionImage')->name('your_model.positionImages');
        </code>
    </pre>
@endsection