<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sub-category.index', ['sub_categories' => SubCategory::all()]); //category_id collecting
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sub-category.create', ['categories' => Category::where('status', 1)->orderBy('id', 'desc')->get()]); //category row collecting
//        return view('admin.sub-category.create', ['categories'=>Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate(
            [
                'category_id' => 'required|integer|exists:categories,id',
                'name'        => 'required|string|unique:sub_categories,name',
                'description' => 'nullable|string',
                'image'       => 'required|image|mimes:jpeg,png,jpg,gif',
            ]
        );
        SubCategory::newSubCategory($request);
        return back()->with('message', 'Sub Category info created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $sub_category)
    {
        return view('admin.sub-category.edit', [
            'sub_category' => $sub_category, //will get specific sub-category id's row info
            'categories'   => Category::where('status', 1)->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $sub_category)
    {
        SubCategory::updateSubCategory($request, $sub_category->id);
        return redirect('/sub-category')->with('message', 'Sub Category info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $sub_category)
    {
        SubCategory::deleteSubCategory($sub_category->id);
        return back()->with('message', 'Sub Category info delete successfully');
    }
}
