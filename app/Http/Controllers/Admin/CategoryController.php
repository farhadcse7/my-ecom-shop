<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store()
    {
        return view('admin.category.index');
    }

    public function edit()
    {
        return view('admin.category.index');
    }

    public function update()
    {
        return view('admin.category.index');
    }

    public function destroy()
    {
        return view('admin.category.index');
    }

}
