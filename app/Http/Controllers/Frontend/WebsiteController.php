<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use function Monolog\alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function category($id, Request $request)
    {
        $query = Product::where('category_id', $id);

        // Handle Sorting
        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy == 'lowest_price') {
                $query->orderBy('selling_price', 'asc');
            } elseif ($sortBy == 'highest_price') {
                $query->orderBy('selling_price', 'desc');
            } else {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        // Handle brand filtering
        if ($request->has('brands') && !empty($request->brands)) {
            $brands = $request->input('brands');
            $query->whereIn('brand_id', $brands);
        }

        // Handle subcategory filtering
        if ($request->has('subcategories') && !empty($request->subcategories)) {
            $subcategories = $request->input('subcategories');
            $query->whereIn('sub_category_id', $subcategories);
        }

        // Handle color filtering (only if colors are selected)
        if ($request->has('colors') && !empty($request->colors)) {
            $colors = $request->input('colors');
            $query->whereHas('colors', function ($q) use ($colors) {
                $q->whereIn('colors.id', $colors);
            });
        }

        // Handle sizes checkbox filtering
        if ($request->has('sizes') && !empty($request->sizes)) {
            $sizes = $request->input('sizes');
            $query->whereHas('sizes', function ($q) use ($sizes) {
                $q->whereIn('sizes.id', $sizes);
            });
        }

        // Handle size filtering
        if ($request->has('size') && !empty($request->size)) {
            $sizeId = $request->input('size');
            $query->whereHas('sizes', function ($q) use ($sizeId) {
                $q->where('sizes.id', $sizeId);
            });
        }

        // Handle price filtering
        // if ($request->has('min_price') && $request->has('max_price')) {
        //     $minPrice = $request->input('min_price');
        //     $maxPrice = $request->input('max_price');
        //     $query->whereBetween('selling_price', [$minPrice, $maxPrice]);
        // }

        // Handle price filtering (only if price filter is applied)
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->input('min_price', 0); // Default to 0 if not provided
            $maxPrice = $request->input('max_price', 200000); // Default to 200000 if not provided
            $query->whereBetween('selling_price', [$minPrice, $maxPrice]);
        }

        $perPage = $request->has('per_page') ? $request->input('per_page') : 2; // Default to 2 items per page
        $products = $query->paginate($perPage);

        // Fetch subcategories of the specific category
        $subcategories = SubCategory::where('category_id', $id)->get();
        $colors = Color::all();
        $brands = Brand::all();
        $sizes = Size::all();

        return view('website.category.index', [
            'products'   => $products,
            'categoryId' => $id,
            'perPage'    => $perPage,
            'sidebar_subcategories' => $subcategories,
            'colors' => $colors,
            'brands' => $brands,
            'sizes' => $sizes,
        ]);

        // return view('website.category.index', [
        //     //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
        //     //'products' => Product::where('category_id', $id)->latest()->get(),
        //     'products'   => Product::where('category_id', $id)->latest()->paginate(2),
        //     'categoryId' => $id, // Pass the category ID to use in the sortBy method
        // ]);
    }

    public function subCategory($id)
    {
        return view('website.sub-category.index', [
            //'categories' => Category::all(), // 'categories' added globally into AppServiceProvider.php file
            'products' => Product::where('sub_category_id', $id)->latest()->get()
        ]);
    }

    //product details
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
            'related_products' => $related_products,
            'colors'           => Color::all()
        ]);
    }

    //ajax search
    public function ajaxSearch()
    {
        $search   = $_GET['query'];
        $products = Product::where('name', 'like', '%' . $search . '%')->latest()->get();
        return response()->json($products);
    }

    //ajax sorting
    public function sortBy(Request $request)
    {
        if (!$request->has('category_id') || !$request->has('sort_by')) {
            return response()->json(['error' => 'Missing required parameters']);
        }

        $query = Product::where('category_id', $request->category_id);

        // Handle sorting
        if ($request->sort_by == 'lowest_price') {
            $products = $query->orderBy('selling_price', 'asc')->paginate(2);
        } elseif ($request->sort_by == 'highest_price') {
            $products = $query->orderBy('selling_price', 'desc')->paginate(2);
        } else {
            $products = $query->paginate(2);
        }

        // Render HTML content for products
        $view = view('website.category.index-content', [
            'products'    => $products,
            'currentSort' => $request->sort_by,
            'categoryId'  => $request->category_id,
        ])->render();

        // Generate pagination
        $pagination = $products->hasPages() ? $products->links('pagination::bootstrap-5')->render() : '';

        // Return a JSON response with HTML and pagination
        return response()->json([
            'html'       => $view,
            'pagination' => $pagination,
        ]);
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
