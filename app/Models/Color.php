<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    private static $color;

    public static function newColor($request)
    {
        self::$color              = new Color();
        self::$color->name        = $request->name;
        self::$color->code        = $request->code;
        self::$color->description = $request->description;
        self::$color->status      = $request->status;
        self::$color->save();
    }

    public static function updateColor($request, $id)
    {
        self::$color              = Color::find($id);
        self::$color->name        = $request->name;
        self::$color->code        = $request->code;
        self::$color->description = $request->description;
        self::$color->status      = $request->status;
        self::$color->save();
    }

    public static function deleteColor($id)
    {
        self::$color = Color::find($id);
        self::$color->delete();
    }

    // for many to many relationship with product - product filtering with color and product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_colors', 'color_id', 'product_id');
    }


}
