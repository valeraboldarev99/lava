<?php

namespace App\Modules\Backuper\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Backuper\Models\Backuper;

class IndexController extends Controller
{
    protected $routePrefix = 'admin.backuper.';

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('status');
    }

    public function getModel()
    {
        return new Backuper;
    }

    /**
     * Show index view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $folders[''] = 'Все каталоги';

        $files = scandir(public_path('uploads/'));
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $folders[$file] = $file;
        }

        return view('Backuper::admin.index', [
            'routePrefix' => $this->routePrefix,
            'folders' => $folders,
            'files_entities' => $this->getModel()->where('dump_type', 'files')->order()->limit(15)->get(),
            'db_entities' => $this->getModel()->where('dump_type', 'data_base')->order()->limit(15)->get(),
        ]);
    }

    /**
     * Backup uploads files.
     * @param Request $request
     * 
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function backupUploads(Request $request)
    {
        $requestArray = $request->all();
        $sourceDir = public_path('uploads/' . $requestArray['folder']);
        $archiveName = public_path('uploads_dump_' . Date("y-m-d_H-i-s") . '.zip');

        if($requestArray["all_time"] == 1)
        {
            $cutoffDate = NULL;
        }
        else {
            $cutoffDate = [
                "date_from" =>strtotime($requestArray["date_from"]),
                "date_to" =>strtotime($requestArray["date_to"]),
            ];
        }
        $zip = new \ZipArchive();

        if ($zip->open($archiveName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            $this->addFilesToZip($zip, $sourceDir, '', $cutoffDate);

            if($zip->numFiles > 0)
            {
                $zip->close();
    
                $this->saveData([
                    'dump_type'     => 'files',
                    'ip'            => $request->ip(),
                    'date_from'     => $requestArray["date_from"],
                    'date_to'       => $requestArray["date_to"],
                    'all_time'      => $requestArray["all_time"],
                    'folder'        => $requestArray['folder'],
                ]);
                
                // HTTP-ответ для скачивания архива
                return response()->download($archiveName)->deleteFileAfterSend(true);
            }
            else {
                // если нет файлов
                return redirect()->back()->with('message', trans('Backuper::adminpanel.no_files'));
            }
        } else {
            // Обработка ошибки, если архив не может быть создан
            return redirect()->back()->with('message', trans('Backuper::adminpanel.error_create_archive'));
        }
    }

    /**
     * Add files to zip.
     * @param \ZipArchive $zip
     * @param string $sourceDir - files directory 
     * @param string $relativePath - catalog relative path 
     * @param array $cutoffDate - date interval 
     * 
     * @return void
     */
    public function addFilesToZip($zip, $sourceDir, $relativePath = '', $cutoffDate) {
        $files = scandir($sourceDir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
    
            $filePath = $sourceDir . '/' . $file;
            $fileRelativePath = $relativePath . '/' . $file;
    
            if (is_dir($filePath)) {
                // Если это каталог, рекурсивно добавляем его содержимое
                $this->addFilesToZip($zip, $filePath, $fileRelativePath, $cutoffDate);
            } else {
                // Если это файл и он был создан или обновлен в указанный период, добавляем его в архив
                if($cutoffDate != NULL && 
                    filemtime($filePath) >= $cutoffDate["date_from"] && 
                    filemtime($filePath) <= $cutoffDate["date_to"])
                {
                    $zip->addFile($filePath, $fileRelativePath);
                }
                elseif($cutoffDate == NULL) {
                    $zip->addFile($filePath, $fileRelativePath);
                }
            }
        }
    }

    /**
     * Backup Data Base.
     * @param Request $request
     * 
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function backupDataBase(Request $request)
    {
        // Имя файла для дампа
        $dumpFileName = 'database_dump' . Date("y-m-d_H-i-s") . '.sql';

        // Путь, где будет сохранен дамп
        $dumpPath = storage_path('app/' . $dumpFileName);

        // Создаем дамп базы данных
        exec("mysqldump -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > " . $dumpPath);

        // Проверяем, что дамп успешно создан
        if (file_exists($dumpPath)) {
            $this->saveData([
                'dump_type'     => 'data_base',
                'ip'            => $request->ip(),
            ]);

            // Отправляем дамп как файл для скачивания
            return response()->download($dumpPath, $dumpFileName)->deleteFileAfterSend(true);
        } else {
            // В случае ошибки
            return redirect()->back()->with('message', 'Unable to create database dump');
        }
    }

    /**
     * Save backaper data to data base. 
     * @param array $data - An associative array containing the data to be saved.
     * 
     * @return void
     */
    public function saveData($data)
    {
        $data['datatime'] = date('Y-m-d H:i:s');
        $data['user_login'] = Auth::user()->email;
        $this->getModel()->create($data);
    }
}