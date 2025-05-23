<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    private static $product, $image, $directory, $imageName, $imageUrl;

    public static function newProduct($request)
    {
        self::$image     = $request->file('image');
        self::$imageName = time() . '-' . self::$image->getClientOriginalName();
        self::$directory = 'uploads/product-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory . self::$imageName;

        self::$product                    = new Product();
        self::$product->category_id       = $request->category_id;
        self::$product->sub_category_id   = $request->sub_category_id;
        self::$product->brand_id          = $request->brand_id;
        self::$product->unit_id           = $request->unit_id;
        self::$product->name              = $request->name;
        self::$product->code              = $request->code;
        self::$product->short_description = $request->short_description;
        self::$product->long_description  = $request->long_description;
        self::$product->regular_price     = $request->regular_price;
        self::$product->selling_price     = $request->selling_price;
        self::$product->stock_amount      = $request->stock_amount;
        self::$product->meta_title        = $request->meta_title;
        self::$product->meta_description  = $request->meta_description;
        self::$product->image             = self::$imageUrl;
        self::$product->status            = $request->status;
        self::$product->save();
        return self::$product; //for other image
    }

    public static function updateProduct($request, $id)
    {
        self::$product = Product::find($id);
        if ($request->file('image')) {
            if (self::$product->image) {
                unlink(self::$product->image);
            }
            self::$image     = $request->file('image');
            self::$imageName = time() . '-' . self::$image->getClientOriginalName();
            self::$directory = 'uploads/product-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl = self::$directory . self::$imageName;
        } else {
            self::$imageUrl = self::$product->image;
        }

        self::$product->category_id       = $request->category_id;
        self::$product->sub_category_id   = $request->sub_category_id;
        self::$product->brand_id          = $request->brand_id;
        self::$product->unit_id           = $request->unit_id;
        self::$product->name              = $request->name;
        self::$product->code              = $request->code;
        self::$product->short_description = $request->short_description;
        self::$product->long_description  = $request->long_description;
        self::$product->regular_price     = $request->regular_price;
        self::$product->selling_price     = $request->selling_price;
        self::$product->stock_amount      = $request->stock_amount;
        self::$product->meta_title        = $request->meta_title;
        self::$product->meta_description  = $request->meta_description;
        self::$product->image             = self::$imageUrl;
        self::$product->status            = $request->status;
        self::$product->save();
    }

    public static function deleteProduct($id)
    {
        self::$product = Product::find($id);
        unlink(self::$product->image);
        self::$product->delete();
    }

    //product one to one relation with Category, Brand, Unit and many relation to ProductImage - to show data into show.blade file
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    // for many to many relationship with product - product filtering with color and product
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id');
    }

    // for many to many relationship with product - product filtering with size and product
    public function sizes()
    {
        // return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
        return $this->belongsToMany(Size::class, 'product_sizes');
    }

}
