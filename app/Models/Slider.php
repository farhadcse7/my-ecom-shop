<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    private static $slider, $image, $directory, $imageName, $imageUrl;

    public static function newSlider($request)
    {
        self::$image     = $request->file('image');
        self::$imageName = time() . '-' . self::$image->getClientOriginalName();
        self::$directory = 'uploads/slider-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory . self::$imageName;

        self::$slider              = new Slider();
        self::$slider->heading     = $request->heading;
        self::$slider->title       = $request->title;
        self::$slider->sub_title   = $request->sub_title;
        self::$slider->image       = self::$imageUrl;
        self::$slider->button_text = $request->button_text;
        self::$slider->button_link = $request->button_link;
        self::$slider->status      = $request->status;
        self::$slider->save();
    }

    public static function updateSlider($request, $id)
    {
        self::$slider = Slider::find($id);
        if ($request->file('image')) {
            if (self::$slider->image) {
                unlink(self::$slider->image);
            }
            self::$image     = $request->file('image');
            self::$imageName = time() . '-' . self::$image->getClientOriginalName();
            self::$directory = 'uploads/slider-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl = self::$directory . self::$imageName;
        } else {
            self::$imageUrl = self::$slider->image;
        }

        self::$slider->heading     = $request->heading;
        self::$slider->title       = $request->title;
        self::$slider->sub_title   = $request->sub_title;
        self::$slider->image       = self::$imageUrl;
        self::$slider->button_text = $request->button_text;
        self::$slider->button_link = $request->button_link;
        self::$slider->status      = $request->status;
        self::$slider->save();
    }

    public static function deleteSlider($id)
    {
        self::$slider = Slider::find($id);
        unlink(self::$slider->image);
        self::$slider->delete();
    }
}
