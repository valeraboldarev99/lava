@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Добавление ViewComposers в модуль</a></h1>
@endsection

@section('content')
    <h2>ДДобавление ViewComposers</h2>
    
    <p>В вашем модуле в config/settings.php добавить:</p>
    <pre>
        <code>
            'providers'	=> [
                'path'  => ['view1', 'view2'],

                //Примеры:
                'App\Modules\AdminPanel\Http\ViewComposers\MenuComposer' => ['AdminPanel::common.sidebar'],
                // 'App\Modules\AdminPanel\Http\ViewComposers\MainComposer22' => ['Settings::main', 'Settings::main__mob'], //for example
            ],
        </code>
    </pre>
    <p>В вашем модуле в Http добавить каталог ViewComposers с фалом ViewComposerName.php</p>
    <p>Пример файла:</p>
    <pre>
        <code>
            &lt;?php
            namespace App\Modules\YourModel\Http\ViewComposers;

            use Illuminate\View\View;

            class ViewComposerNameComposer
            {
                public function compose(View $view)
                {
                    $str = 'Hello World';

                    $view->with('str', $str);
                }
            }
        </code>
    </pre>
    <p></p>
    <p></p>

@endsection