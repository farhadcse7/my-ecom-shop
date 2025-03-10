<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    private static $productImage, $productImages, $image, $directory, $imageName, $imageUrl;

    public static function newProductImage($images, $id)
    {
        //        Check if $images is null or not an array
        //        if (is_null($images) || empty($images)) {
        //            self::$productImage             = new ProductImage();
        //            self::$productImage->product_id = $id;
        //            self::$productImage->image      = null; // or set a default value
        //            self::$productImage->save();
        //            return; // Exit the function
        //        }

        // Proceed with the loop if $images is valid
        foreach ($images as $image) {
            self::$imageName = time() . '-' . $image->getClientOriginalName();
            self::$directory = 'uploads/product-other-images/';
            $image->move(self::$directory, self::$imageName); //here not self::$image->move(), it's loop $image
            self::$imageUrl = self::$directory . self::$imageName;

            self::$productImage             = new ProductImage();
            self::$productImage->product_id = $id;
            self::$productImage->image      = self::$imageUrl;
            self::$productImage->save();
        }
    }

    public static function updateProductImage($images, $id)
    {
        //removing existing images
        self::$productImages = ProductImage::where('product_id', $id)->get();
        foreach (self::$productImages as $productImage) {
            if (file_exists($productImage->image)) {
                unlink($productImage->image);
            }
            $productImage->delete();
        }
        //adding new images
        self::newProductImage($images, $id);
    }

    public static function deleteProductImage($id)
    {
        self::$productImages = ProductImage::where('product_id', $id)->get();
        foreach (self::$productImages as $productImage) {
            if (file_exists($productImage->image)) {
                unlink($productImage->image);
            }
            $productImage->delete();
        }
    }
}
