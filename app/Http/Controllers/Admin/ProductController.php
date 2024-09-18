<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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
            'units'          => Unit::all()
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
        // return $request;
        $this->product = Product::newProduct($request);
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
            'units'          => Unit::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Product::updateProduct($request, $product->id);
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
        ProductImage::deleteProductImage($product->id);
        return back()->with('message', 'Product info delete successfully');
    }

}
