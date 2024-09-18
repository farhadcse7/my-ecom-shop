<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.home.index', ['products' => Product::latest()->take(8)->get()]);
    }

    public function category()
    {
        return view('website.category.index');
    }

    public function product()
    {
        return view('website.product.index');
    }
}
