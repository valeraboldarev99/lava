@extends('AdminPanel::layouts.app')

@section('title')
    <h1><a href="{{route('admin.manual')}}">Экспорт/Импорт</a></h1>
@endsection

@section('content')
    <h2>Добавление экспорта/импорта модуля</h2>
    
    <p>В вашем модуле в папке Http добавить новый каталог ExportAndImport с файлами:</p>
    <ul>
        <li><a href="#Export">Export.php</a></li>
        <li><a href="#Import">Import.php</a></li>
    </ul>

    <p>В контроллере администратора прописать методы:</p>
    <pre>
        <code>
            &lt;?php
            namespace App\Modules\YourModel\Http\Controllers\Admin;

            //..
            use App\Modules\YourModel\Http\ExportAndImport\Export;
            use App\Modules\YourModel\Http\ExportAndImport\Import;
            use Maatwebsite\Excel\Facades\Excel;

            class IndexController extends AdminMainController
            {
                //..

                public function export()
                {
                    return Excel::download(new Export, date('Y_m_d_H_i_s').'_news.csv');
                }

                public function import(Request $request)
                {
                    $request_array = $request->all();

                    $import = new Import();
                    $import->import($request_array['import_file']);

                    if($import->failures()->isNotEmpty())
                    {
                        return back()->withFailures($import->failures());
                    }

                    return redirect()->route($this->routePrefix . 'index')->withStatus(trans('AdminPanel::adminpanel.import_success'));
                }

                //..
            }
            
        </code>
    </pre>

    <p id="Export">Пример содержания файла - <code>ExportAndImport/Export</code>:</p>
    <pre>
        <code>
            &lt;?php
            namespace App\Modules\YourModel\Http\ExportAndImport;

            use App\Modules\YourModel\Models\YourModel;
            use Maatwebsite\Excel\Concerns\FromCollection;
            use Maatwebsite\Excel\Concerns\WithHeadings;

            class Export implements FromCollection, WithHeadings
            {
                public function collection()
                {
                    return YourModel::all();
                }

                public function headings(): array
                {
                    return getTableFields();
                }
            }
        </code>
    </pre>
    
    <p id="Import">Пример содержания файла - <code>ExportAndImport/Import</code>:</p>
    <pre>
        <code>
            &lt;?php

            namespace App\Modules\YourModel\Http\ExportAndImport;

            use App\Modules\YourModel\Models\YourModel;
            use Maatwebsite\Excel\Concerns\ToModel;
            use Maatwebsite\Excel\Concerns\WithHeadingRow;
            use Maatwebsite\Excel\Concerns\Importable;
            use Maatwebsite\Excel\Concerns\WithValidation;
            use Maatwebsite\Excel\Concerns\SkipsOnFailure;
            use Maatwebsite\Excel\Concerns\SkipsFailures;
            use Maatwebsite\Excel\Validators\Failure;

            class Import implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
            {
                use Importable, SkipsFailures;

                public function model(array $row)
                {
                    $tableFields = getTableFields();

                    $importArray = [];
                    foreach ($tableFields as $field) {
                        $importArray[$field] = $row[$field];
                    }

                    return new YourModel($importArray);
                }

                public function rules(): array
                {
                    return [
                        '*.title' => 'required',
                    ];
                }
            }
        </code>
    </pre>

    <p>В админ панели где выводятся все записи переопределить topmenu</p>
    <p>Добавятся кнопки экспорта и импорта</p>
    <pre>
        <code>
            &#64;section('topmenu')
                <div class="header-controls">
                    &#64;include('AdminPanel::controls.main_buttons')
                    &#64;include('AdminPanel::common.import_export')
                </div>
                &#64;include('AdminPanel::common.localization')
            &#64;endsection
        </code>
    </pre>

    <p>Прописать роуты:</p>
    <pre>
        <code>
            Route::get('/your_model/export/', 'IndexController@export')->name('your_model.export');
            Route::post('/your_model/import/', 'IndexController@import')->name('your_model.import');
        </code>
    </pre>

    <p>Можно использовать официальную документацию: <a href="https://docs.laravel-excel.com/3.1/getting-started/" target="_blank">https://docs.laravel-excel.com/3.1/getting-started/</a></p>
@endsection