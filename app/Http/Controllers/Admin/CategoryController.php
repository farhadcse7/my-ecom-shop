<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index', ['categories' => Category::all()]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'        => 'required|string|unique:categories,name',
                'description' => 'required|string',
                'image'       => 'required|image|mimes:jpeg,png,jpg,gif',
            ]
        );
        Category::newCategory($request);
        return back()->with('message', 'Category info created successfully');
    }

    public function edit($id)
    {
        return view('admin.category.edit', ['category' => Category::find($id)]);
    }

    public function update(Request $request, $id)
    {
        Category::updateCategory($request, $id);
        return redirect('/category/index')->with('message', 'Category info updated successfully');
    }

    public function destroy($id)
    {
        Category::deleteCategory($id);
        return back()->with('message', 'Category info deleted successfully');
    }

}
