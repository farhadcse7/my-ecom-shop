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
            'products'   => Product::latest()->take(8)->get(),
            'categories' => Category::all()
        ]);
    }

    public function category($id)
    {
        return view('website.category.index', [
            'categories' => Category::all(),
            'products'   => Product::where('category_id', $id)->latest()->get()
        ]);
    }

    public function product($id)
    {
        return view('website.product.index', [
            'categories' => Category::all(),
            'product'    => Product::find($id)
        ]);
    }
}
