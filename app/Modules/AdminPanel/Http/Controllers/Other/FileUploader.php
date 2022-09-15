<?php

namespace App\Modules\AdminPanel\Http\Controllers\Other;

use Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use InterventionImage;

trait FileUploader
{
    protected $name = false;

	protected function after($entity)
	{
	    if (getMethod() == 'store' || getMethod() == 'update') {
	        $this->upload($entity);
	    }
	}

	public function upload($entity)
	{
	    $configs = getModuleConfig('uploads');
	    $fields = [];

	    if(!isset($configs) || empty($configs))
	    {
	    	return false;
	    }

	    foreach ($configs as $key => $config) {
	    	$fields[] = $key;
	    }

	    foreach ($fields as $field)
	    {
	    	if (Request::hasFile($field)) {
	    	    $file = Request::file($field);
	    	    if ($this->uploader($file, $configs[$field])) {
	    	        $entity->{$field} = $this->name;
	    	    }
	    	}
	    }

	    $entity->save();
	}

	public function generateName($ext)
	{
	    $this->name = Date("dmy_His") . "_" . Str::random(6) . '.' . $ext;

	    return $this->name;
	}

    public function uploader($file, $config)
    {
        $path = public_path() . $config['path'];
        $this->dir($path);
        $this->generateName($file->getClientOriginalExtension());

        if (!isset($config['sizes']) || empty($config['sizes'])) {
            $file->move($path, $this->name);

            return true;
        }
        else {
            return $this->resizeAndUpload($file, $config);
        }
    }

    public function resizeAndUpload($file, $config)
    {
        $parrent_path = public_path() . $config['path'];
        foreach ($config['sizes'] as $size)
        {
            $path = $parrent_path . $size['path'];
            $this->dir($path);
            $img = Image::make($file->getRealPath());

            if ($size['width'] && $size['height']) {
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

            $path = $path . $this->name;

            $img->save($path);

            if(isset($size['webp']) && $size['webp'] && $size['webp'] > 0) {
            	$this->convertToWebp($path, $size['webp']);
            }
        }

        return true;
    }

    protected function convertToWebp($path, $quality = 100)
    {
    	$dir = pathinfo($path, PATHINFO_DIRNAME);
    	$name = pathinfo($path, PATHINFO_FILENAME);
    	$ext = pathinfo($path, PATHINFO_EXTENSION);

    	$dest = "{$dir}/{$name}.webp";
    	$is_alpha = false;

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

	protected function dir($path)
	{
	    if (!File::isDirectory($path)) {
	        File::makeDirectory($path, 0777, true, true);
	    }
	}

    public function deleteFile($id, $field)
    {
        $entity  = $this->getModel()->findOrFail($id);
        $configs = getModuleConfig('uploads');
        if (array_key_exists($field, $configs)) {
            if (isset($entity->{$field})) {
                if ($this->deleteInDirs($entity->{$field}, $configs[$field])) {
                    $entity->{$field} = null;

                    $entity->save();
                }
                else {
                    $entity->{$field} = null;

                    $entity->save();
                }
            }
        }
    }

    protected function deleteInDirs($filename, $config)
    {
        $baseDir = public_path() . $config['path'];
        if (!isset($config['sizes']) || empty($config['sizes'])) {
            @unlink($baseDir . $filename);

            // return true;
        } else {
            foreach ($config['sizes'] as $size) {
                $path = $baseDir . $size['path'] . $filename;
                if(isset($size['webp']) && $size['webp'] && $size['webp'] > 0)
                {
                    $dir = pathinfo($path, PATHINFO_DIRNAME);
                    $name = pathinfo($path, PATHINFO_FILENAME);
                    $webpPath = "{$dir}/{$name}.webp";
                    @unlink($webpPath);
                }
                @unlink($path);
            }
        }

        // return true;
    }
}