<?php

namespace App\Modules\AdminPanel\Models;

trait FileUploader
{
	private function imagePath($field, $size)
	{
		$image = getModuleConfig('uploads.' . $field);
		if(!$image)
		{
			return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_field', ['field' => $field]));
		}
		$path = $image['path'];
		if($path[0] != '/')
		{
			$path = '/' . $path;
		}
		if($path[-1] != '/')
		{
			$path = '/' . $path;
		}

		if(!isset($image['sizes'][$size]))
		{
			return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_size', ['size' => $size]));
		}

		return $size_path = $path . $size;
	}

    public function getImage($field, $size)
    {
    	$path = $this->imagePath($field, $size);

    	if($this->{$field} == NULL)
    	{
    		return false;
    	}
		return $path . '/' . $this->{$field};
    }

    public function getImageWebp($field, $size)
    {
    	$image = $this->getImage($field, $size);
    	$uploads_data = getModuleConfig('uploads.' . $field . '.sizes.' . $size);

    	if(!isset($uploads_data['webp']) || !$uploads_data['webp'] && $uploads_data['webp'] == 0)
    	{
			return redirect()->back()->with('message', trans('AdminPanel::adminpanel.messages.no_image_webp'));
    	}

    	$dir = pathinfo($image, PATHINFO_DIRNAME);
    	$file_name = pathinfo($image, PATHINFO_FILENAME);

		$webp_image = "{$dir}/{$file_name}.webp";

    	return $webp_image;
    }
}