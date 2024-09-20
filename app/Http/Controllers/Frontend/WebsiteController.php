<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.home.index', [
            //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
            'products' => Product::latest()->take(8)->get()
        ]);
    }

    public function category($id)
    {
        return view('website.category.index', [
            //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
            'products' => Product::where('category_id', $id)->latest()->get()
        ]);
    }

    public function subCategory($id)
    {
        return view('website.category.index', [
            //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
            'products' => Product::where('sub_category_id', $id)->latest()->get()
        ]);
    }

    public function product($id)
    {
        return view('website.product.index', [
            //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
            'product' => Product::find($id)
        ]);
    }
}
