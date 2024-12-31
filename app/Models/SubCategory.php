<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    private static $subCategory, $image, $directory, $imageName, $imageUrl;

    public static function newSubCategory($request)
    {
        self::$image     = $request->file('image');
        self::$imageName = time() . '-' . self::$image->getClientOriginalName();
        self::$directory = 'uploads/sub-category-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory . self::$imageName;

        self::$subCategory              = new SubCategory();
        self::$subCategory->category_id = $request->category_id;
        self::$subCategory->name        = $request->name;
        self::$subCategory->description = $request->description;
        self::$subCategory->image       = self::$imageUrl;
        self::$subCategory->status      = $request->status;
        self::$subCategory->save();
    }

    public static function updateSubCategory($request, $id)
    {
        self::$subCategory = SubCategory::find($id);
        if ($request->file('image')) {
            if (self::$subCategory->image) {
                unlink(self::$subCategory->image);
            }
            self::$image     = $request->file('image');
            self::$imageName = time() . '-' . self::$image->getClientOriginalName();
            self::$directory = 'uploads/sub-category-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl = self::$directory . self::$imageName;
        } else {
            self::$imageUrl = self::$subCategory->image;
        }

        self::$subCategory->category_id = $request->category_id;
        self::$subCategory->name        = $request->name;
        self::$subCategory->description = $request->description;
        self::$subCategory->image       = self::$imageUrl;
        self::$subCategory->status      = $request->status;
        self::$subCategory->save();
    }

    public static function deleteSubCategory($id)
    {
        self::$subCategory = SubCategory::find($id);
        unlink(self::$subCategory->image);
        self::$subCategory->delete();
    }

    //sub category one to one relation with category
    public function category()
    {
        return $this->belongsTo(Category::class);
        //        return $this->belongsTo(Category::class, 'cat_id'); //when category_id not used, here cat_id foreign key

    }

    //for category deletion cascade
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
