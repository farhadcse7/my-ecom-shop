<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    private static $productColor, $productColors;

    public static function newProductColor($colors, $id)
    {
        $colors = $colors ?? []; // If $colors is null, assign it an empty array
//        if ($colors === null) {
//            $colors = [];
//        }
        foreach ($colors as $color) {
            self::$productColor             = new ProductColor();
            self::$productColor->product_id = $id;
            self::$productColor->color_id    = $color;
            self::$productColor->save();
        }
    }

    public static function updateProductColor($colors, $id)
    {
        //deletion existing
        self::$productColors=ProductColor::where('product_id',$id)->get();
        foreach (self::$productColors as $productColor)
        {
            $productColor->delete();
        }
        //creation
        self::newProductColor($colors, $id);
    }

    public static function deleteProductColor($id)
    {
        self::$productColors = ProductColor::where('product_id', $id)->get();
        foreach (self::$productColors as $productColor) {
            $productColor->delete();
        }
    }

    //for product view file this relation method works only
    public function color()
    {
        return $this->belongsTo(Color::class);
    }


}
