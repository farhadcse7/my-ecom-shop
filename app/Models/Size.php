<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    private static $size;

    public static function newSize($request)
    {
        self::$size              = new Size();
        self::$size->name        = $request->name;
        self::$size->code        = $request->code;
        self::$size->description = $request->description;
        self::$size->status      = $request->status;
        self::$size->save();
    }

    public static function updateSize($request, $id)
    {
        self::$size              = Size::find($id);
        self::$size->name        = $request->name;
        self::$size->code        = $request->code;
        self::$size->description = $request->description;
        self::$size->status      = $request->status;
        self::$size->save();
    }

    public static function deleteSize($id)
    {
        self::$size = Size::find($id);
        self::$size->delete();
    }

     // for many to many relationship with product - product filtering with size and product
    public function products()
    {
        // return $this->belongsToMany(Product::class, 'product_sizes', 'size_id', 'product_id');
        return $this->belongsToMany(Product::class, 'product_sizes');
    }
}
