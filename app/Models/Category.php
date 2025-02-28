<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Carbon\this;

class Category extends Model
{
    use HasFactory;

    private static $category, $image, $directory, $imageName, $imageUrl;

    public static function newCategory($request)
    {
        self::$image     = $request->file('image');
        self::$imageName = time() . '-' . self::$image->getClientOriginalName();
        self::$directory = 'uploads/category-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory . self::$imageName;

        self::$category              = new Category();
        self::$category->name        = $request->name;
        self::$category->description = $request->description;
        self::$category->image       = self::$imageUrl;
        self::$category->status      = $request->status;
        self::$category->save();
    }

    public static function updateCategory($request, $id)
    {
        self::$category = Category::find($id);
        if ($request->file('image')) {
            if (self::$category->image) {
                unlink(self::$category->image);
            }
            self::$image     = $request->file('image');
            self::$imageName = time() . '-' . self::$image->getClientOriginalName();
            self::$directory = 'uploads/category-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl = self::$directory . self::$imageName;
        } else {
            self::$imageUrl = self::$category->image;
        }

        self::$category->name        = $request->name;
        self::$category->description = $request->description;
        self::$category->image       = self::$imageUrl;
        self::$category->status      = $request->status;
        self::$category->save();
    }

    public static function deleteCategory($id)
    {
        self::$category = Category::find($id);
        unlink(self::$category->image);
        self::$category->delete();
    }

    //function for website menubar category linked subcategory list
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }


    //for showing specific category total products - added
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
