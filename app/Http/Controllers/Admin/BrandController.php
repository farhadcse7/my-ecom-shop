<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.brand.index', ['brands' => Brand::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'        => 'required|string|unique:brands,name',
                'description' => 'nullable|string|max:1000',
                'image'       => 'required|image|mimes:jpeg,png,jpg,gif',
            ]
        );

        Brand::newBrand($request);
        return back()->with('message', 'Brand info created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return view('admin.brand.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand) //($id) -old
    {
        return view('admin.brand.edit', ['brand' => $brand]); //['brand' => Brand::find($id)]) -old
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand) //(Request $request, $id) -old
    {
        //return $request;
        Brand::updateBrand($request, $brand->id); //($request, $id) -old
        return redirect('/brand')->with('message', 'Brand info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand) //($id) -old
    {
        Brand::deleteBrand($brand->id); //($id) -old
        return redirect('/brand')->with('message', 'Brand info deleted successfully');
    }
}
