<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    private static $courier, $image, $directory, $imageName, $imageUrl;

    public static function newCourier($request)
    {
        self::$image     = $request->file('logo');
        self::$imageName = time() . '-' . self::$image->getClientOriginalName();
        self::$directory = 'uploads/courier-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageUrl = self::$directory . self::$imageName;

        self::$courier          = new Courier();
        self::$courier->name    = $request->name;
        self::$courier->email   = $request->email;
        self::$courier->mobile  = $request->mobile;
        self::$courier->address = $request->address;
        self::$courier->logo    = self::$imageUrl;
        self::$courier->status  = $request->status;
        self::$courier->save();
    }

    public static function updateCourier($request, $id)
    {
        self::$courier = Courier::find($id);
        if ($request->file('logo')) {
            if (self::$courier->logo) {
                unlink(self::$courier->logo);
            }
            self::$image     = $request->file('logo');
            self::$imageName = time() . '-' . self::$image->getClientOriginalName();
            self::$directory = 'uploads/courier-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageUrl = self::$directory . self::$imageName;
        } else {
            self::$imageUrl = self::$courier->logo;
        }
        self::$courier->name    = $request->name;
        self::$courier->email   = $request->email;
        self::$courier->mobile  = $request->mobile;
        self::$courier->address = $request->address;
        self::$courier->logo    = self::$imageUrl;
        self::$courier->status  = $request->status;
        self::$courier->save();
    }

    public static function deleteCourier($id)
    {
        self::$courier = Courier::find($id);
        unlink(self::$courier->logo);
        self::$courier->delete();
    }
}
