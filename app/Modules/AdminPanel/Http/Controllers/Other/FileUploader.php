<?php

namespace App\Modules\AdminPanel\Http\Controllers\Other;

use DB;
use Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as FileRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait FileUploader
{
    protected $name = false;

    /**
        * after saving, we call upload()
        * @param $entity
    */
    protected function after($entity)
    {
        if (getMethod() == 'store' || getMethod() == 'update') {
            $this->upload($entity);
        }
        if(getMethod() == 'destroy') {
            $this->deleteAllFiles($entity);
        }
    }

    /**
        * Uploading images to the server
        * @param $entity
    */
    public function upload($entity)
    {
        $configs = getModuleConfig('uploads');                                     //this is the uploads.php file in the module config

        if(!isset($configs) || empty($configs))                                    //if uploads.php file is empty
        {
        	return false;
        }

        foreach ($configs as $key => $config) {                                    //we will get the file fields from uploads.php
        	$fields[] = $key;
        }

        $this->fileValidator($entity, $configs, $fields);                           //file validation

        foreach ($fields as $field)
        {
            if(!isset($configs[$field]['multiple']) && !isset($entity->getMultipleFilesTables()[$field]))                 //not multi uploading
            {                                                                      //single uploading
                if (Request::hasFile($field)) {
                    $file = Request::file($field);                                     //getting the file from request
                    $file_size = $file->getSize();                                      // get the file size in bytes

                    if ($this->uploader($file, $configs[$field])) {                    //if the file is saved, we will save its name in the database
                        $entity->{$field} = $this->name;                                //write filename to main table

                        !isset($configs[$field]['field_name']) ?: $entity->{$configs[$field]['field_name']} = $file->getClientOriginalName();           //if there is a field_name, write the original name
                        !isset($configs[$field]['field_size']) ?: $entity->{$configs[$field]['field_size']} = $file_size;                               //if there is a field_size, write the $size
                    }
                }
            }
        }

        $entity->save();
    }

    /**
        * File validation
        * @param $entity
        * @param $config
        * @param $fields
    */
    protected function fileValidator($entity, $configs, $fields)
    {
        if(count($fields) == 0)
        {
            return [];
        }

        $rules = [];
        foreach ($fields as $field) {
            // if(!isset($configs[$field]['multiple']) || $configs[$field]['multiple'] != true)
            // {
                $rules[$field] = $this->checkMimes($configs[$field]['validator']);
            // }
        }

        $validator = Validator::make(Request::all(), $rules, $this->getUploadMessages(), $this->getUploadAttributes());

        if ($validator->fails()) {
            foreach ($fields as $field) {
                if (array_key_exists($field, $validator->errors()->messages())) {
                    $entity->{$field} = null;
                }
            }

            $entity->save();

            throw new ValidationException($validator);
        }

        return $fields;
    }

    /**
        * Check mimes validator
        * @param $validator - from file upload.php
    */
    protected function checkMimes($validator)
    {
        if(preg_match('#.*(mimes:[^|]+).*#', $validator)) {
            return $validator;
        }

        return 'mimetypes:' . implode(',', config('mimes.' . 'mimetypes')) . '|' . $validator;
    }

    /**
        * Receiving validation error messages
    */
    protected function getUploadMessages() : array
    {
        return [];
    }

    /**
        * Getting the names of validation fields
    */
    protected function getUploadAttributes() : array
    {
        return [];
    }

    /**
        * Image name generation
        * @param $ext - Extension
    */
    public function generateName($ext)
    {
        $this->name = Date("dmy_His") . "_" . Str::random(6) . '.' . $ext;
        return $this->name;
    }

    /**
        * Saving images
        * @param $entity
    */
    public function uploader($file, $config)
    {
        $path = public_path() . $config['path'];                        //путь к каталогу
        $this->dir($path);                                              //if there is no directory on the server, then we will create it
        $this->generateName($file->getClientOriginalExtension());       //generate a name and pass its extension

        if (!isset($config['sizes']) || empty($config['sizes'])) {      //if the uploads file does not specify the dimensions for the field, then we will simply save
            $file->move($path, $this->name);

            return true;
        }
        else {
            return $this->resizeAndUpload($file, $config);              //if the dimensions are prescribed, then we will go through them and save the corresponding pictures
        }
    }

    /**
        * Resizing and saving files in the desired directory
        * @param $file
        * @param $config
    */
    public function resizeAndUpload($file, $config)
    {
        $parrent_path = public_path() . $config['path'];                    //parent path for folders with sizes
        foreach ($config['sizes'] as $size)
        {
            $path = $parrent_path . $size['path'];                          //path to folder size
            $this->dir($path);                                              //let's check if this directory exists
            $img = Image::make($file->getRealPath());                       //we will get an object an image that we will save

            if ($size['width'] && $size['height']) {                        //if uploads have width and height
                if ($size['width'] >= $size['height']) {
                    $img->resize($size['width'], null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                else {
                    $img->resize(null, $size['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                $img->crop($size['width'], $size['height']);
            }

            if (!$size['height']) {
                $img->resize($size['width'], null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            if (!$size['width']) {
                $img->resize(null, $size['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $path = $path . $this->name;                                    //the path to the file

            $img->save($path);                                              //save the image

            if(isset($size['webp']) && $size['webp'] && $size['webp'] > 0) {    //if there is a webp field or its value is greater than 0, the value will affect the percentage of quality
            	$this->convertToWebp($path, $size['webp']);
            }
        }

        return true;
    }

    /**
        * Convert the image to webp
        * @param $path -file path
        * @param $quality - default 100
    */
    protected function convertToWebp($path, $quality = 100)
    {
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        $name = pathinfo($path, PATHINFO_FILENAME);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $dest = "{$dir}/{$name}.webp";
        $is_alpha = false;                             //transparency of the image

        if (mime_content_type($path) == 'image/png') {
            $is_alpha = true;
            $img = imagecreatefrompng($path);
        } elseif (mime_content_type($path) == 'image/jpeg') {
            $img = imagecreatefromjpeg($path);
        } else {
            return $path;
        }

        if ($is_alpha) {
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
        }

        imagewebp($img, $dest, $quality);
        return $dest;
    }

    /**
        * if there is no directory on the server, then we will create it
        * @param $path
    */
    protected function dir($path)
    {
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    /**
        * Deleting images and files
        * @param $id
        * @param $field - field name
    */
    public function deleteFile($id, $field)
    {
        $entity  = $this->getModel()->findOrFail($id);
        $configs = getModuleConfig('uploads');
        if (array_key_exists($field, $configs)) {                                   //is there a selected field in the config
            if (isset($entity->{$field})) {                                         //is there such a field in the database
                if ($this->deleteInDirs($entity->{$field}, $configs[$field])) {     //delete from derictory
                    $entity->{$field} = null;                                       //clear the fields in the table

                    $entity->save();
                }
                else {
                    $entity->{$field} = null;

                    $entity->save();
                }
            }
        }
        else {
            return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_field', ['field' => $field]));
        }
    }

    /**
        * Deleting images and files in a directory
        * @param $config
        * @param $filename
    */
    protected function deleteInDirs($filename, $config)
    {
        $baseDir = public_path() . $config['path'];
        if (!isset($config['sizes']) || empty($config['sizes'])) {
            @unlink($baseDir . $filename);                                          //deleting the file
        } else {
            foreach ($config['sizes'] as $size) {                                   //let's go through all the sizes
                $path = $baseDir . $size['path'] . $filename;
                if(isset($size['webp']) && $size['webp'] && $size['webp'] > 0)      //if there is a webp then we will delete it
                {
                    $dir = pathinfo($path, PATHINFO_DIRNAME);
                    $name = pathinfo($path, PATHINFO_FILENAME);
                    $webpPath = "{$dir}/{$name}.webp";
                    @unlink($webpPath);
                }
                @unlink($path);
            }
        }
        return true;
    }

    /**
        * Deleting multiple images or files (ajax)
        * @param $entity_id
        * @param $field
        * @param $file_id
    */
    public function deleteMultiFiles($entity_id, $field, $file_id)
    {
        $entity  = $this->getModel()->findOrFail($entity_id);
        $configs = getModuleConfig('uploads');

        $entityImages = DB::table($entity->getMultipleFilesTables()[$field]);
        $entityImagesName = $entityImages->where('id', $file_id)->pluck($configs[$field]['field_name'])->first();

        if (array_key_exists($field, $configs)) {                                   //is there a selected field in the config
            if ($this->deleteInDirs($entityImagesName, $configs[$field])) {         //delete from derictory
                $entityImages->delete($file_id);

                return response()->json('deleted');
            }
        }
        else {
            return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_field', ['field' => $field]));
        }
    }

    /**
    * Uploading multiple (ajax)
    * @param $request [field, entity_id, _token ...]
    */
    public function multiUploader(FileRequest $request)
    {
        $request_array = $request->all();

        $configs = getModuleConfig('uploads');                                     //this is the uploads.php file in the module config

        if(!isset($configs) || empty($configs))                                    //if uploads.php file is empty
        {
            return false;
        }

        foreach ($configs as $key => $config) {                                    //we will get the file fields from uploads.php
            $fields[] = $key;
        }

        $entity = $this->getModel()->where('id', $request_array['entity_id'])->first();
        $field = $request_array['field'];

        $this->fileValidator($entity, $configs, $fields);                           //file validation

        if(isset($configs[$field]['multiple']) && $configs[$field]['multiple'] == true && isset($entity->getMultipleFilesTables()[$field]))                 //multi uploading
        {
            if(!empty($request_array[$field]))
            {
                $file = $request_array[$field];                                        //get all files from field
                $multipleTable = \DB::table($entity->getMultipleFilesTables()[$field]); //table where files will be uploaded
                //write it in your model: protected $multipleFilesTables = ['field_name'  => 'table_name_for_images',];

                $file_size = $file->getSize();                                      // get the file size in bytes

                if ($this->uploader($file, $configs[$field])) {                    //if the file is saved, we will save its name in the database
                    if($configs[$field]['save_type'] == 'as_image')
                    {
                        return $this->imagesUploader($entity, $request_array, $multipleTable);
                    }
                    if($configs[$field]['save_type'] == 'as_file')
                    {
                        $request_array['saved_name'] ? $request_array['saved_name'] : $file->getClientOriginalName();
                        $request_array['file_size'] = $file_size;
                        $request_array['format'] = $file->getClientOriginalExtension();
                        return $this->filesUploader($entity, $request_array, $multipleTable);
                    }
                }
            }
        }
    }

    /**
    * Uploading multiple images (ajax)
    * @param $entity
    * @param $request_array
    * @param $multipleTable
    */
    protected function imagesUploader($entity, $request_array, $multipleTable)
    {
        $file_id = $multipleTable->insertGetId([                                        //write data to multi_table
            'name' => $this->name,
            'position'  => 0,
            'parent_id'  => $entity->id,
        ]);

        $file_path = $entity->getPathMultiImage($this->name, $request_array['field'], $request_array['show_img_size']);

        return response()->json([
            'file_id' =>    $file_id,
            'block_id' => $request_array['field'] . '_' . $entity->id . '_' . $file_id,
            'file_name' =>  $this->name,
            'file_path' =>  $file_path,
            'delete_route' =>   route($this->routePrefix . 'deleteMultiFiles', ['entity_id' => $entity->id, 'field' => $request_array['field'], 'file_id' => $file_id]),
        ]);
    }

    /**
    * Uploading multiple files (ajax)
    * @param $entity
    * @param $request_array
    * @param $multipleTable
    */
    public function filesUploader($entity, $request_array, $multipleTable)
    {
        $file_id = $multipleTable->insertGetId([                                        //write data to multi_table
            'saved_name' => $request_array['saved_name'],
            'file_name' => $this->name,
            'file_size' => $request_array['file_size'],
            'format' => $request_array['format'],
            'position'  => 0,
            'parent_id'  => $entity->id,
        ]);

        $file_path = $entity->getPathMultiFile($this->name, $request_array['field']);

        return response()->json([
            'file_id' => $file_id,
            'block_id' => $request_array['field'] . '_' . $entity->id . '_' . $file_id,
            'saved_name' => $request_array['saved_name'],
            'file_name' =>  $this->name,
            'file_size' => $entity->getFileSize($request_array['file_size']),
            'format' => $request_array['format'],
            'file_path' =>  $file_path,
            'delete_route' =>   route($this->routePrefix . 'deleteMultiFiles', ['entity_id' => $entity->id, 'field' => $request_array['field'], 'file_id' => $file_id]),
        ]);
    }

    /**
    * Delete all entity's files, when delete entity
    * @param $entity
    */
    public function deleteAllFiles($entity)
    {
        $configs = getModuleConfig('uploads');                                     //this is the uploads.php file in the module config

        if(!isset($configs) || empty($configs))                                    //if uploads.php file is empty
        {
            return false;
        }

        foreach ($configs as $key => $config) {                                    //we will get the file fields from uploads.php
            $fields[] = $key;
        }
        foreach ($fields as $field)
        {
            if(!isset($configs[$field]['multiple']) && !isset($entity->getMultipleFilesTables()[$field]))
            {
                $this->deleteFile($entity->id, $field);
            }
            else {
                $multiFiles = DB::table($entity->getMultipleFilesTables()[$field])->where('parent_id', $entity->id)->get();
                if($multiFiles)
                {
                    foreach ($multiFiles as $file)
                    {
                        if ($this->deleteInDirs($file->{$configs[$field]['field_name']}, $configs[$field])) //file_name's field in table
                        {
                            DB::table($entity->getMultipleFilesTables()[$field])->delete($file->id);
                        }
                    }
                }
            }

        }
        return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.destroy'));
    }

    /**
    * Change file (ajax)
    * @param $request
    */
    public function changeFile(FileRequest $request)
    {
        $request_array = $request->all();
        $field = $request_array['field'];
        $file_id = $request_array['file_id'];
        $entity = $this->getModel();
        $file = DB::table($entity->getMultipleFilesTables()[$field])->where('id', $file_id);
        $file->update([
            'saved_name' => $request_array['new_saved_name'],
        ]);

        return response()->json([
            'file' => $file->first(),
            'block_id' => $field . '_' . $request_array['entity_id'] . '_' . $file_id,
        ]);
    }
}