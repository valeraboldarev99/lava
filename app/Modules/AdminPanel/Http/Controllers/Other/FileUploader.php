<?php

namespace App\Modules\AdminPanel\Http\Controllers\Other;

use Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
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
            if (Request::hasFile($field)) {
                $file = Request::file($field);                                     //getting the file from request
                $file_size = $file->getSize();

                if ($this->uploader($file, $configs[$field])) {                    //if the file is saved, we will save its name in the database
                    $entity->{$field} = $this->name;

                    !isset($configs[$field]['field_name']) ?: $entity->{$configs[$field]['field_name']} = $file->getClientOriginalName();
                    !isset($configs[$field]['field_size']) ?: $entity->{$configs[$field]['field_size']} = $file_size;
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
            $rules[$field] = $this->checkMimes($configs[$field]['validator']);
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
        $entity  = $this->getModel()->findOrFail($id);                              //we'll find it by id
        $configs = getModuleConfig('uploads');
        if (array_key_exists($field, $configs)) {                                   //is there a selected field in the config
            if (isset($entity->{$field})) {                                         //is there such a field in the database
                if ($this->deleteInDirs($entity->{$field}, $configs[$field])) {     //удаляем в дирректории
                    $entity->{$field} = null;                                       //clear the fields in the table

                    $entity->save();
                }
                else {
                    $entity->{$field} = null;

                    $entity->save();
                }
            }
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
    }
}