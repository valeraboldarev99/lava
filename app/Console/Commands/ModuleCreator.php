<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ModuleCretor extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'module:create {module_name}';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    // Комманда для создания модулей через консоль
    // Разработал Валерий valerieboldarev@gmail.com
    // 12.08.2022
    protected $description = 'Creating a module directory and with default files, files contain default content';

    //структура модуля
    protected $structure = [
        'Config',
        'Database' => [
            'Migrations',
            'Seeds'
        ],
        'Http' => [
            'Controllers' => [
                'Admin'
            ],
            'ViewComposers'
        ],
        'Models',
        'Resources' => [
            'lang' => [ 'ru', 'en' ],
            'Views' => [
                'admin'
            ],
        ],
        'Routes'
    ];
    /**
     * Создать новый экземпляр команды.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Выполнить консольную команду.
     *
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        // create module folder
        $path = app_path() . '/Modules/' . ucfirst($this->argument('module_name'));
        if(!is_dir($path))
        {
            mkdir($path);
            foreach ($this->structure as $key => $folder) {
                $this->createFolder($path, $key, $folder);
            }
            dd('Module ' . ucfirst($this->argument('module_name')) . ' created');
        }
        else {
            foreach ($this->structure as $key => $folder) {
                $this->createFolder($path, $key, $folder);
            }
            dd('Module ' . ucfirst($this->argument('module_name')) . ' is exists');
        }
    }

    //создание папок
    private function createFolder($path, $key, $folder)
    {
        if(is_array($folder))
        {
            $path .= '/' . $key;
            if(!is_dir($path))
            {
                mkdir($path);
                $this->createFiles($path, $key);
                foreach ($folder as $key => $inner_folder) {
                    $this->createFolder($path, $key, $inner_folder);
                }
            }
        }
        else {
            $path .= '/' . $folder;
            if(!is_dir($path))
            {
                mkdir($path);
                $this->createFiles($path, $folder);
            }
        }
    }

    //создание файлов
    private function createFiles($path, $folder)
    {
        $files = $this->files();
        if(isset($files[$folder]))
        {
            $files = $files[$folder];
            foreach ($files as $file => $content) {
                if(isset($file) && $file != '')
                {
                    $file = fopen($path . '/' . $file, 'w') or die("Can't create file");
                    fwrite($file, $content);
                    fclose($file);
                }
                if($file == 0)
                {
                    $file = fopen($path . '/' . $content, 'w') or die("Can't create file");
                }
            }
        }
    }

    //1. Папка файла, 2. Имя файла, 3. Содержание файла
    private function files()
    {
        $model_name = $this->argument('module_name');
        return $files = [
            'Config'        => [ 
                'settings.php' => $this->file_settings()
            ],
            'Migrations'    => [
                Date('Y_m_d_hms') . '_create_' . $model_name . '_table.php' => $this->file_migrations()
            ],
            'Seeds'         => [
                ucfirst($model_name) . 'TableSeeder.php' => $this->file_seeds()
            ],
            'Controllers'   => [
                'IndexController.php' => $this->file_userController()
            ],
            'Admin'         => [
                'IndexController.php' => $this->file_adminController()
            ],
            'ViewComposers' => [
                'MainComposer.php' => $this->file_composer()
            ],
            'Models'        => [
                ucfirst($model_name . '.php') => $this->file_model()
            ],
            'ru'            => [
                'adminpanel.php' => $this->file_lang(),
                'index.php' => $this->file_lang()
            ],
            'en'            => [
                'index.php' => $this->file_lang()
            ],
            'Views'         => [
                'index.blade.php' => '',
                'main.blade.php' => ''
            ],
            'admin'         => [
                'index.blade.php' => $this->file_AdminIndex(),
                'form.blade.php' => $this->file_AdminForm()
            ],
            'Routes'        => [
                'web.php' => $this->file_web()
            ]
        ];
    }

    private function file_settings()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "return [" . "\r\n";
        $content .= "    'menu_items' => [" . "\r\n";
        $content .= "        [" . "\r\n";
        $content .= "            'icon'      => 'fa fa-tasks'," . "\r\n";
        $content .= "            'route'     => 'admin." . $this->argument('module_name') . ".index'," . "\r\n";
        $content .= "            'group'     => 'main_group'," . "\r\n";
        $content .= "            'title'     => trans('" . ucfirst($this->argument('module_name')) . "::adminpanel.title')," . "\r\n";
        $content .= "            'priority'  => 10," . "\r\n";
        $content .= "        ]," . "\r\n";
        $content .= "    ]," . "\r\n";
        $content .= "    'localization'      => true," . "\r\n";
        $content .= "    'providers' => [" . "\r\n";
        $content .= "        'App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Http\ViewComposers\MainComposer' => ['" . ucfirst($this->argument('module_name')) . "::main']," . "\r\n";
        $content .= "    ]" . "\r\n";
        $content .= "];";

        return $content;
    }

    private function file_migrations()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "use Illuminate\Support\Facades\Schema;" . "\r\n";
        $content .= "use Illuminate\Database\Schema\Blueprint;" . "\r\n";
        $content .= "use Illuminate\Database\Migrations\Migration;" . "\r\n\n";

        $content .= "class Create" . ucfirst($this->argument('module_name')) . "Table extends Migration" . "\r\n";
        $content .= "{" . "\r\n";
        $content .= "    public function up()" . "\r\n";
        $content .= "    {" . "\r\n";
        $content .= "        Schema::create('" . $this->argument('module_name') . "', function (Blueprint \$table) {" . "\r\n";
        $content .= "            \$table->bigIncrements('id');" . "\r\n";
        $content .= "            \$table->enum('lang', ['ru', 'en'])->index();" . "\r\n";
        $content .= "            \$table->string('title')->nullable();" . "\r\n";
        $content .= "            \$table->tinyInteger('active')->default(1);" . "\r\n";
        $content .= "            \$table->text('content')->nullable();" . "\r\n\n";

        $content .= "            \$table->timestamps();" . "\r\n";
        $content .= "        });" . "\r\n";
        $content .= "    }" . "\r\n\n";

        $content .= "    public function down()" . "\r\n";
        $content .= "    {" . "\r\n";
        $content .= "        Schema::dropIfExists('" . $this->argument('module_name') . "');" . "\r\n";
        $content .= "    }" . "\r\n";
        $content .= "}";

        return $content;
    }

    private function file_seeds()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "namespace App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Database\Seeds;" . "\r\n\n";

        $content .= "use Illuminate\Database\Seeder;" . "\r\n";
        $content .= "use Illuminate\Support\Str;" . "\r\n";
        $content .= "use Illuminate\Support\Facades\DB;" . "\r\n\n";

        $content .= "class " . ucfirst($this->argument('module_name')) . "TableSeeder extends Seeder" . "\r\n";
        $content .= "{" . "\r\n";
        $content .= "    public function run()" . "\r\n";
        $content .= "    {" . "\r\n";
        $content .= "        \$data = [" . "\r\n";
        $content .= "            [" . "\r\n";
        $content .= "                'id' => 1," . "\r\n";
        $content .= "                'lang' => 'ru'," . "\r\n";
        $content .= "                'title' => 'title1'," . "\r\n";
        $content .= "                'active' => 1," . "\r\n";
        $content .= "            ]," . "\r\n";
        $content .= "            [" . "\r\n";
        $content .= "                'id' => 2," . "\r\n";
        $content .= "                'lang' => 'ru'," . "\r\n";
        $content .= "                'title' => 'title2'," . "\r\n";
        $content .= "                'active' => 1," . "\r\n";
        $content .= "            ]," . "\r\n";
        $content .= "        ];" . "\r\n";
        $content .= "        DB::table('" . $this->argument('module_name') . "')->insert(\$data);" . "\r\n";
        $content .= "    }" . "\r\n";

        $content .= "}";

        return $content;
    }

    private function file_adminController()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "namespace App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Http\Controllers\Admin;" . "\r\n\n";

        $content .= "use App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Models\\" . ucfirst($this->argument('module_name')) . ";" . "\r\n";
        $content .= "use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;" . "\r\n\n";

        $content .= "class IndexController extends AdminMainController" . "\r\n";
        $content .= "{" . "\r\n";
        $content .= "    protected \$viewPrefix = '" . ucfirst($this->argument('module_name')) . "';" . "\r\n";
        $content .= "    protected \$routePrefix = 'admin." . $this->argument('module_name') . ".';" . "\r\n\n";

        $content .= "    public function getModel()" . "\r\n";
        $content .= "    {" . "\r\n";
        $content .= "        return new " . ucfirst($this->argument('module_name')) . "();" . "\r\n";
        $content .= "    }" . "\r\n";
        $content .= "}";

        return $content;
    }

    private function file_userController()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "namespace App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Http\Controllers;" . "\r\n\n";

        $content .= "use App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Models\\" . ucfirst($this->argument('module_name')) . ";" . "\r\n";
        $content .= "use App\Modules\AdminPanel\\Http\Controllers\IndexController as Controller;" . "\r\n\n";

        $content .= "class IndexController extends Controller" . "\r\n";
        $content .= "{" . "\r\n";

        $content .= "    public function getModel()" . "\r\n";
        $content .= "    {" . "\r\n";
        $content .= "        return new " . ucfirst($this->argument('module_name')) . "();" . "\r\n";
        $content .= "    }" . "\r\n\n";
        $content .= "    public function index()" . "\r\n";
        $content .= "    {" . "\r\n";
        $content .= "        return 'index page';" . "\r\n";
        $content .= "    }" . "\r\n";
        $content .= "}";

        return $content;
    }

    private function file_composer()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "namespace App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Http\ViewComposers;" . "\r\n\n";

        $content .= "use Illuminate\View\View;" . "\r\n";
        $content .= "use App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Models\\" . ucfirst($this->argument('module_name')) . ";" . "\r\n\n";

        $content .= "class MainComposer" . "\r\n";
        $content .= "{" . "\r\n";
        $content .= "    public function compose(View \$view)" . "\r\n";
        $content .= "    {" . "\r\n";
        $content .= "        \$items = " . ucfirst($this->argument('module_name')) . "::get();" . "\r\n\n";

        $content .= "        \$view->with('items', \$items);" . "\r\n";
        $content .= "    }" . "\r\n";
        $content .= "}";

        return $content;
    }

    private function file_model()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "namespace App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Models;" . "\r\n\n";

        $content .= "use Illuminate\Notifications\Notifiable;" . "\r\n";
        $content .= "use App\Modules\AdminPanel\Models\Model;" . "\r\n\n";

        $content .= "class " . ucfirst($this->argument('module_name')) . " extends Model {" . "\r\n\n";

        $content .= "    use Notifiable;" . "\r\n\n";

        $content .= "    protected \$table = '" . $this->argument('module_name') . "';" . "\r\n";
        $content .= "}";

        return $content;
    }

    private function file_lang()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "return [" . "\r\n";
        $content .= "    'title' => '" . $this->argument('module_name') . "'" . "\r\n";
        $content .="];" . "\r\n";

        return $content;
    }

    private function file_AdminIndex()
    {
        $content = "@extends('AdminPanel::admin.index')" . "\r\n\n";

        $content .= "@section('title')" . "\r\n";
        $content .= "    <h2>{{ __('" . ucfirst($this->argument('module_name')) . "::adminpanel.title') }}</h2>" . "\r\n";
        $content .= "@endsection" . "\r\n\n";

        $content .= "@section('th')" . "\r\n";
        $content .= "    <th>@sortablelink('title', 'Имя')</th>" . "\r\n";
        $content .= "    <th>{{ __('AdminPanel::adminpanel.controls') }}</th>" . "\r\n";
        $content .= "@endsection" . "\r\n\n";

        $content .= "@section('td')" . "\r\n";
        $content .= "    @foreach (\$entities as \$entity)" . "\r\n";
        $content .= "        <tr {!! \$entity->active == 1 ?: 'style=\"background:#f2dede;\"' !!}>" . "\r\n";
        $content .= "            <td>" . "\r\n";
        $content .= "                {{ \$entity->title }}" . "\r\n";
        $content .= "            </td>" . "\r\n";
        $content .= "            <td class=\"controls\">" . "\r\n";
        $content .= "               @include('AdminPanel::controls.entity_all')" . "\r\n";
        $content .= "            </td>" . "\r\n";
        $content .= "        </tr>" . "\r\n";
        $content .= "    @endforeach" . "\r\n";
        $content .= "@endsection" . "\r\n";

        return $content;
    }

    private function file_AdminForm()
    {
        $content =  "@extends('AdminPanel::admin.form')" . "\r\n\n";

        $content .= "@section('title')" . "\r\n";
        $content .= "    <h2>{{ __('" . ucfirst($this->argument('module_name')) . "::adminpanel.title') }}</h2>" . "\r\n";
        $content .= "@endsection" . "\r\n\n";

        $content .= "@section('form_content')" . "\r\n";
        $content .= "    {!! MyForm::open([" . "\r\n";
        $content .= "        'entity' => \$entity," . "\r\n";
        $content .= "        'method' => 'POST'," . "\r\n";
        $content .= "        'store' => \$routePrefix . 'store'," . "\r\n";
        $content .= "        'update' => \$routePrefix . 'update'," . "\r\n";
        $content .= "        'autocomplete' => true]) !!}" . "\r\n\n";

        $content .= "        <div class=\"row\">" . "\r\n";
        $content .= "            <div class=\"col-md-6\">" . "\r\n";
        $content .= "                {!! MyForm::text('title', trans('AdminPanel::fields.title') , \$entity->title) !!}" . "\r\n";
        $content .= "            </div>" . "\r\n\n";

        $content .= "            <div class=\"col-md-2\">" . "\r\n\n";
        $content .= "                {!! MyForm::checkbox('active', trans('AdminPanel::fields.active'), \$entity->active) !!}" . "\r\n";
        $content .= "            </div>" . "\r\n";

        $content .= "            <div class=\"clearfix\"></div>" . "\r\n\n";

        $content .= "            <div class=\"col-md-12\">" . "\r\n";
        $content .= "                {!! MyForm::textarea('content', trans('AdminPanel::fields.content'), \$entity->content, ['rows=\"8\"']) !!}" . "\r\n";
        $content .= "            </div>" . "\r\n";
        $content .= "        </div>" . "\r\n";
        $content .= "@endsection" . "\r\n";

        return $content;
    }

    private function file_web()
    {
        $content = "<?php" . "\r\n\n";

        $content .= "use Illuminate\Support\Facades\Route;" . "\r\n\n";

        $content .= "Route::group([" . "\r\n";
        $content .= "        'prefix' => Localization::locale()," . "\r\n";
        $content .= "        'middleware' => 'setLocale'], function() {" . "\r\n\n";

        $content .= "    \$namespace = 'App\Modules\\" . ucfirst($this->argument('module_name')) . "\\Http\Controllers';" . "\r\n\n";

        $content .= "    Route::group(['namespace' => \$namespace, 'middleware' => ['web']], function() {" . "\r\n";
        $content .= "    // admin" . "\r\n";
        $content .= "        Route::group(['middleware' => ['auth', 'status']," . "\r\n";
        $content .= "                'prefix' => config('cms.url.admin_prefix')," . "\r\n";
        $content .= "                'as' => config('cms.admin_prefix')," . "\r\n";
        $content .= "                'namespace' => 'Admin'], function() {" . "\r\n\n";

        $content .= "            Route::resource('/" . $this->argument('module_name') . "', 'IndexController');" . "\r\n";
        $content .= "        });" . "\r\n\n";

        $content .= "    //user" . "\r\n";
        $content .= "        Route::resource('/" . $this->argument('module_name') . "', 'IndexController');" . "\r\n";
        $content .= "     });" . "\r\n";
        $content .= " });" . "\r\n";
        return $content;
    }
}