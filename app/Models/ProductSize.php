<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    private static $productSize, $productSizes;

    public static function newProductSize($sizes, $id)
    {
        $sizes = $sizes ?? []; // If $sizes is null, assign it an empty array
        foreach ($sizes as $size) {
            self::$productSize             = new ProductSize();
            self::$productSize->product_id = $id;
            self::$productSize->size_id    = $size;
            self::$productSize->save();
        }
    }

    public static function updateProductSize($sizes, $id)
    {
       //deletion existing
        self::$productSizes=ProductSize::where('product_id',$id)->get();
       foreach (self::$productSizes as $productSize)
       {
           $productSize->delete();
       }
       //creation
        self::newProductSize($sizes, $id);
    }

    public static function deleteProductSize($id)
    {
        self::$productSizes = ProductSize::where('product_id', $id)->get();
        foreach (self::$productSizes as $productSize) {
            $productSize->delete();
        }
    }

    //for product view file this relation method works only
    public function size()
    {
        return $this->belongsTo(Size::class);
    }


}
