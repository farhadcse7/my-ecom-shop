<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.slider.index', ['sliders' => Slider::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'heading'     => 'required|string',
                'title'       => 'required|string',
                'sub_title'   => 'required|string',
                'image'       => 'required',
                'button_text' => 'required|string',
            ]
        );
        Slider::newSlider($request);
        return back()->with('message', 'Slider info created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        return view('admin.slider.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        //return $request;
        Slider::updateSlider($request, $slider->id);
        return redirect('/slider')->with('message', 'Slider info updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        Slider::deleteSlider($slider->id);
        return redirect('/slider')->with('message', 'Slider info deleted successfully');
    }
}
