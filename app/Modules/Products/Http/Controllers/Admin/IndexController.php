<?php

namespace App\Modules\Products\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use App\Modules\Products\Models\Products;
use App\Modules\Products\Models\ProductsCategories;
use App\Modules\AdminPanel\Http\Controllers\Other\Position;
use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    use FileUploader, Position;

    protected $viewPrefix = 'Products';
    protected $routePrefix = 'admin.products.';
    protected $fileRoutePrefix = 'admin.products_files.';
    // protected $imageRoutePrefix = 'admin.products_images.';

    public function getModel()
    {
        return new Products();
    }

    public function create()
    {
        $entity = $this->getModel();

        $this->after($entity);

        return view($this->getFormViewName(), [
            'entity' => $entity,
            'categories' => ProductsCategories::pluck('title', 'id'),
        ]);
    }

    public function edit($id)
    {
        $entity = $this->getModel()->findOrFail($id);

        $this->after($entity);

        return view($this->getFormViewName(), [
            'routePrefix'   => $this->routePrefix,
            'entity'        => $entity,
            'categories' => ProductsCategories::pluck('title', 'id'),
        ]);
    }

    protected function getIndexViewName()
    {
        return $this->viewPrefix . '::products_admin.index';
    }

    protected function getFormViewName()
    {
        return $this->viewPrefix . '::products_admin.form';
    }

    protected function share()
    {
        View::share('routePrefix', $this->routePrefix);
        View::share('fileRoutePrefix', $this->fileRoutePrefix);
        // View::share('imageRoutePrefix', $this->imageRoutePrefix);
        View::share('model_name', class_basename($this->getModel()));
    }

}