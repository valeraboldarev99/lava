<?php

namespace App\Modules\Products\Http\Controllers;

use App\Modules\Products\Models\Products;
use App\Modules\Structure\Models\Structure;
use App\Modules\Products\Models\ProductsCategories;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

class IndexController extends Controller
{
    public    $perPage     = 1;
    protected $viewPrefix = 'Products';

    public function getModel()
    {
        return new Products();
    }

    public function index()
	{
		$categories = ProductsCategories::where('active', 1)->get();
		if($categories->count() <= 1) {
            return view($this->getIndexViewName(), [
                'page'	=> Structure::where('module', 'products')->first(),
            ]);
		}
		else {
            $getfirstcategory_parent = ProductsCategories::where('active', 1)->first();
			$getfirstcategory = ProductsCategories::where('active', 1)->first();
            return redirect()->route('products.categories', [
                'parent_slug' => $getfirstcategory_parent->id, 
                'slug' => $getfirstcategory->id
            ]);
		}
	}

    public function categories($parent_id, $id = NULL)
    {
        $parent_category = ProductsCategories::where('active', 1)->first();
        
        if($id == NULL)
        {
            $checked_category = ProductsCategories::where('active', 1)
                                                    ->first();
            if(!isset($checked_category))
            {
                $checked_category = $parent_category;
            }
            else {
                return redirect()->route('products.categories', [
                    'parent_id' => $parent_category->id, 
                    'id' => $checked_category->id
                ]);
            }  
        }
        else {
            $checked_category = ProductsCategories::where('id', $id)->first();
        }
        
        $categories = ProductsCategories::where('active', 1)
                                            ->get();
        
        $products = Products::where('active', 1)->get();
        $items = $this->getModel()
                            ->items()
                            ->where('category_id', $checked_category->id)
                            ->paginate($this->perPage);

        return view('Products::index', [
            'items' => $items,
            'products' => $products,
            'parent_category' => $parent_category,
            'checked_category' => $checked_category,
            'categories' => $categories,
            'routePrefix' => $this->routePrefix,
            'page' => Structure::where('module', 'products')->first()
        ]);                                            
    }
}