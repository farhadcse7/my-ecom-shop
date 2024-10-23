<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.product.index', ['products' => Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create', [
            'categories'     => Category::all(),
            'sub_categories' => SubCategory::all(),
            'brands'         => Brand::all(),
            'units'          => Unit::all(),
            'colors'         => Color::all(),
            'sizes'          => Size::all()
        ]);
    }

    // function for dynamically get subcategory according to category
    public function getSubCategoryByCategory()
    {
        return response()->json(SubCategory::where('category_id', $_GET['id'])->get()); //getting all subcategory according to category_id
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'category_id'       => 'required|integer|exists:categories,id',
            'sub_category_id'   => 'required|integer|exists:sub_categories,id',
            'brand_id'          => 'required|integer|exists:brands,id',
            'unit_id'           => 'required|integer|exists:units,id',
            'name'              => 'required|string|unique:products,name',
            'code'              => 'required|string|unique:products,code',
            //'color'             => 'required|array', // Ensure color is an array
            //'color.*'           => 'string', // Ensure each item in the color array is a string
            //'size'              => 'required|array', // Ensure size is an array
            //'size.*'            => 'string', // Ensure each item in the size array is a string
            'short_description' => 'nullable|string|max:255',
            'long_description'  => 'nullable|string',
            'regular_price'     => 'required|integer|min:0',
            'selling_price'     => 'required|integer|min:0|lt:regular_price',
            'stock_amount'      => 'required|integer|min:0',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:1000',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif',
            'other_image'       => 'required', // Ensure the array itself is not empty
            'other_image.*'     => 'required|image|mimes:jpeg,png,jpg,gif', //for this one table = product_images_table
            'hit_count'         => 'integer|min:0',
            'sales_count'       => 'integer|min:0'
        ]);

        $this->product = Product::newProduct($request);
        ProductColor::newProductColor($request->color, $this->product->id); //saving process of product colors
        ProductSize::newProductSize($request->size, $this->product->id); //saving process of product sizes
        ProductImage::newProductImage($request->file('other_image'), $this->product->id); //saving process of product other images
        return back()->with('message', 'Product info created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.product.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Fetch subcategories that match the product's category_id when edit page run
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();
        return view('admin.product.edit', [
            'product'        => $product,
            'categories'     => Category::all(),
            //'sub_categories' => SubCategory::all(),
            'sub_categories' => $subCategories,
            'brands'         => Brand::all(),
            'units'          => Unit::all(),
            'colors'         => Color::all(),
            'sizes'          => Size::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Product::updateProduct($request, $product->id);
        ProductColor::updateProductColor($request->color, $product->id);
        ProductSize::updateProductSize($request->size, $product->id);
        //if added new images then remove existing and adding new images
        if ($request->file('other_image')) {
            ProductImage::updateProductImage($request->file('other_image'), $product->id);
        }
        return redirect('/product')->with('message', "product info updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Product::deleteProduct($product->id);
        ProductColor::deleteProductColor($product->id);
        ProductSize::deleteProductSize($product->id);
        ProductImage::deleteProductImage($product->id);
        return back()->with('message', 'Product info delete successfully');
    }

}
