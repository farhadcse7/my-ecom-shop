<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use function Monolog\alert;

class WebsiteController extends Controller
{
    public function index()
    {
        return view('website.home.index', [
            //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
            'sliders'             => Slider::where('status', 1)->get(),
            'categories_list'     => Category::withCount('products')->limit(5)->get(), //category list and specific category's total product count
            'trendingProducts'    => Product::latest()->take(8)->get(),
            'randomProducts'      => Product::inRandomOrder()->limit(6)->get(),
            'newArrivalsProducts' => Product::latest()->limit(5)->get(),
            'discountProducts'    => Product::inRandomOrder()->limit(3)->get(),
            'featuredProducts'    => Product::inRandomOrder()->limit(3)->get(),
            'sellingProducts'     => Product::inRandomOrder()->limit(3)->get(),
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
        $product          = Product::find($id);
        $related_products = Product::where('sub_category_id', $product->sub_category_id)
            ->where('id', '!=', $id) // Exclude the current product
            ->limit(8)
            ->get();
        return view('website.product.index', [
            //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
            'product'          => $product,
            'related_products' => $related_products
        ]);
    }

    //ajax search
    public function ajaxSearch()
    {
        $search   = $_GET['query'];
        $products = Product::where('name', 'like', '%' . $search . '%')->latest()->get();
        return response()->json($products);
    }

    public function blog()
    {
        return view('website.blog.blog');
    }

    public function about()
    {
        return view('website.about.about');
    }

    public function contact()
    {
        return view('website.contact.contact');
    }

}
