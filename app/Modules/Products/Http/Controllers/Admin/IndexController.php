<?php

namespace App\Modules\Products\Http\Controllers\Admin;

use App\Modules\Products\Models\Products;
use App\Modules\Products\Models\ProductsCategories;
use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;

class IndexController extends AdminMainController
{
    use FileUploader;

    protected $viewPrefix = 'Products';
    protected $routePrefix = 'admin.products.';

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
            'categories' => ProductsCategories::get(),
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
}