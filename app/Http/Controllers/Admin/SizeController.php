<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.size.index', ['sizes' => Size::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.size.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'        => 'required|string|unique:sizes,name',
                'code'        => 'required|string|unique:sizes,code',
                'description' => 'nullable|string|max:1000',
            ]
        );

        Size::newSize($request);
        return back()->with('message', 'Size info created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        return view('admin.size.edit', ['size' => $size]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        Size::updateSize($request, $size->id);
        return redirect('/size')->with('message', 'Size info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        Size::deleteSize($size->id);
        return redirect('/size')->with('message', 'Size info deleted successfully');
    }
}
