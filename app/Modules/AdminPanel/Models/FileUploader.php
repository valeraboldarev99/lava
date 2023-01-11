<?php

namespace App\Modules\AdminPanel\Models;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

trait FileUploader
{
    // protected $multipleFilesTables = [               //example
    //     'field_name'  => 'table_name_for_images',
    // ];

    /**
        * Path to the image directory
        * @param $field
        * @param $size
    */
    private function getPath($field, $size = null)
    {
        $image = getModuleConfig('uploads.' . $field);
        if(!$image)                                         // there is no such field
        {
            return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_field', ['field' => $field]));
        }
        $path = $image['path'];             // further processing of the path in case there is no / at the beginning and end in uploads file
        if($path[0] != '/')
        {
            $path = '/' . $path;
        }
        if($path[-1] != '/')                // --1 end of path string
        {
            $path = '/' . $path;
        }

        if($size != null)
        {
            if(!isset($image['sizes'][$size]))  // there is no such size
            {
                return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_size', ['size' => $size]));
            }
            return $size_path = $path . $size . '/';
        }

        return $path;
    }

    /**
        * Path to the image
        * @param $field
        * @param $size
    */
    public function getImagePath($field, $size = null)
    {
        $path = $this->getPath($field, $size);

        if($this->{$field} == NULL)
        {
            return false;
        }
        return $path . $this->{$field};
    }

    /**
        * Path to the webp image
        * @param $field
        * @param $size
    */
    public function getImageWebpPath($field, $size = null)
    {
        $image = $this->getImagePath($field, $size);
        $uploads_data = getModuleConfig('uploads.' . $field . '.sizes.' . $size);

        if(!isset($uploads_data['webp']) || !$uploads_data['webp'] && $uploads_data['webp'] == 0)           //does this image have a webp version
        {
            return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_webp'));
        }

        $dir = pathinfo($image, PATHINFO_DIRNAME);
        $file_name = pathinfo($image, PATHINFO_FILENAME);

        $webp_image = "{$dir}/{$file_name}.webp";

        return $webp_image;
    }

    /**
        * Path to the file
        * @param $field
        * @param $size
    */
    public function getFilePath($field)
    {
        $path = $this->getPath($field);

        if($this->{$field} == NULL)
        {
            return false;
        }
        return $path . $this->{$field};
    }

    /**
        * Path to the multiple image
        * @param $field
        * @param $size
    */
    public function getPathMultiImage($image_name, $field, $size = null)
    {
        $path = $this->getPath($field, $size);

        return $path . $image_name;
    }

    /**
        * get the file name and size(if needed)
        * @param $field_name- string
        * @param $size - bool, nullable
    */
    public function getFileName($field, bool $size = null)
    {
        if($field_name = getModuleConfig('uploads.' . $field . '.field_name'))
        {
            $file_name = $this->{$field_name};                                          //check if there is a field for the file_name in uploads.php and get it
            if($size && $size != NULL)                                                  //do I need to show the file size
            {
                if($field_size = getModuleConfig('uploads.' . $field . '.field_size'))  //check if there is a field for the file_size in uploads.php and get it
                {
                    $file_size = $this->getFileSize($this->{$field_size});
                    $file_name .= ', ' . $file_size;                                    //add file size to file name
                }
            }
            return $file_name;
        }
        return $this->{$field};
    }

    /**
        * get the file size in bytes/kilobytes/megabytes
        * @param $file_size in bytes
    */
    public function getFileSize(int $file_size)
    {
        if($file_size < 1000) { $file_size .= trans('AdminPanel::adminpanel.file_sizes.b'); }
        if($file_size > 1000 && $file_size < 1000000) { $file_size = round($file_size / 1024, 2) . trans('AdminPanel::adminpanel.file_sizes.kb'); }
        if($file_size > 1000000) {$file_size =  round($file_size / 1024 / 1024, 2) . trans('AdminPanel::adminpanel.file_sizes.mb');}

        return $file_size;
    }

    /**
        * Get the fields of the multiload files and their tables
        *
        * In the model, you need to define the variable "protected $multipleFilesTables", 
        * in which to register an array of field names and their tables.

        * Example: protected $multipleFilesTables = ['field_name'  => 'table_name_for_images',];
    */
    public function getMultipleFilesTables()
    {
        return ($this->multipleFilesTables ?: []);
    }
}