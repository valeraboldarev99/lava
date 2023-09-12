<?php

namespace App\Modules\Products\Http\Controllers\Admin;

use App\Modules\Products\Models\ProductsCategories;
use App\Modules\AdminPanel\Http\Controllers\Other\Position;
use App\Modules\AdminPanel\Http\Controllers\Admin\AdminMainController;
use App\Modules\AdminPanel\Http\Controllers\Other\FileUploader;

class ProductsCategoriesController extends AdminMainController
{
    use FileUploader, Position;

    protected $viewPrefix = 'Products';
    protected $routePrefix = 'admin.products_categories.';

    public function getModel()
    {
        return new ProductsCategories();
    }

    protected function getIndexViewName()
    {
        return $this->viewPrefix . '::products_categories_admin.index';
    }

    protected function getFormViewName()
    {
        return $this->viewPrefix . '::products_categories_admin.form';
    }
}