<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.color.index', ['colors' => Color::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.color.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'        => 'required|string|unique:colors,name',
                'code'        => 'required|string|unique:colors,code',
                'description' => 'nullable|string|max:1000',
            ]
        );

        Color::newColor($request);
        return back()->with('message', 'Color info created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Color $color)
    {
        return view('admin.color.edit', ['color' => $color]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Color $color)
    {
        Color::updateColor($request, $color->id);
        return redirect('/color')->with('message', 'Color info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        Color::deleteColor($color->id);
        return redirect('/color')->with('message', 'Color info deleted successfully');
    }
}
