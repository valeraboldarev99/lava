<?php

namespace App\Modules\AdminPanel\Models;

trait FileUploader
{
    /**
        * Path to the image directory
        * @param $field
        * @param $size
    */
    private function imagePath($field, $size)
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

        if(!isset($image['sizes'][$size]))  // there is no such size
        {
            return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_size', ['size' => $size]));
        }

        return $size_path = $path . $size;
    }

    /**
        * Path to the image
        * @param $field
        * @param $size
    */
    public function getImage($field, $size)
    {
        $path = $this->imagePath($field, $size);

        if($this->{$field} == NULL)
        {
            return false;
        }
        return $path . '/' . $this->{$field};
    }

    /**
        * Path to the webp image
        * @param $field
        * @param $size
    */
    public function getImageWebp($field, $size)
    {
        $image = $this->getImage($field, $size);
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
}