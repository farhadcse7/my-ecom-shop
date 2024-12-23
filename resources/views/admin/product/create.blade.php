@extends('admin.master')
@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Product Module</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Product</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">Create Product Form</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{session('message')}}</p>
                    <form class="form-horizontal" action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <label for="" class="col-md-3 form-label">Category Name</label>
                            <div class="col-md-9">
                                <!-- getSubCategoryByCategory(this.value) for dynamically get subcategory according to category and function used in master file-->
                                <select class="form-control" name="category_id" onchange="getSubCategoryByCategory(this.value)">
                                    <option value="">-- Select Category Name --</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->has('category_id') ? $errors->first('category_id') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="" class="col-md-3 form-label">Sub Category Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="sub_category_id" id="subCategory">
                                    <!-- subCategory id for ajax response load-->
                                    <option value="">-- Select Sub Category Name --</option>
                                    @foreach($sub_categories as $sub_category)
                                        <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->has('sub_category_id') ? $errors->first('sub_category_id') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Brand Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="brand_id">
                                    <option value="">-- Select Brand Name --</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->has('brand_id') ? $errors->first('brand_id') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Unit Name</label>
                            <div class="col-md-9">
                                <select class="form-control" name="unit_id">
                                    <option value="">-- Select Unit Name --</option>
                                    @foreach($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->has('unit_id') ? $errors->first('unit_id') : ''}}</span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="subcategoryName" class="col-md-3 form-label">Product Name</label>
                            <div class="col-md-9">
                                <input class="form-control" name="name" id="subcategoryName" placeholder="Product Name" type="text">
                                <span class="text-danger">{{$errors->has('name') ? $errors->first('name') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="categoryName" class="col-md-3 form-label">Product Code</label>
                            <div class="col-md-9">
                                <input class="form-control" name="code" id="categoryName" placeholder="Product Code" type="text">
                                <span class="text-danger">{{$errors->has('code') ? $errors->first('code') : ''}}</span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="categoryName" class="col-md-3 form-label">Product Color</label>
                            <div class="col-md-9">
                                <select name="color[]" multiple="" class="form-control select2-show-search form-select" data-placeholder="Choose one">
                                    <option label="Choose one"></option>
                                    @foreach($colors as $color)
                                    <option value="{{$color->id}}">{{$color->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->has('color') ? $errors->first('color') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="categoryName" class="col-md-3 form-label">Product Size</label>
                            <div class="col-md-9">
                                <select name="size[]" multiple="" class="form-control select2-show-search" data-placeholder="Choose one">
                                    <option label="Choose one"></option>
                                    @foreach($sizes as $size)
                                        <option value="{{$size->id}}">{{$size->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->has('size') ? $errors->first('size') : ''}}</span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="description" class="col-md-3 form-label">Short Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="short_description" id="description" placeholder="Short Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="summernote" class="col-md-3 form-label">Long Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="long_description" id="summernote" placeholder="long Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Product Price</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input class="form-control" name="regular_price" placeholder="regular price" type="number"/>
                                    <input class="form-control" name="selling_price" placeholder="selling price" type="number"/>
                                </div>
                                <span class="text-danger">{{$errors->has('regular_price') ? $errors->first('regular_price') : ''}}</span>
                                <span class="text-danger">{{$errors->has('selling_price') ? $errors->first('selling_price') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="stock_amount" class="col-md-3 form-label">Stock Amount</label>
                            <div class="col-md-9">
                                <input class="form-control" name="stock_amount" placeholder="Stock Amount" id="stock_amount" type="number"/>
                                <span class="text-danger">{{$errors->has('stock_amount') ? $errors->first('stock_amount') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="meta_title" class="col-md-3 form-label">Meta title</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="meta_title" id="meta_title" placeholder="Short Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="meta_description" class="col-md-3 form-label">Meta description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="meta_description" id="meta_description" placeholder="Short Description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="image" class="col-md-3 form-label">Product Image</label>
                            <div class="col-md-9">
                                <input class="form-control" name="image" id="image" type="file"/>
                                <span class="text-danger">{{$errors->has('image') ? $errors->first('image') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="otherimage" class="col-md-3 form-label">Product Other Image</label>
                            <div class="col-md-9">
                                <input class="form-control" name="other_image[]" multiple id="otherimage" type="file"/>
                                <span class="text-danger">
                                    {{-- Error if no image is uploaded --}}
                                    @if ($errors->has('other_image'))
                                        {{ $errors->first('other_image') }}
                                    @endif

                                    {{-- Errors for each uploaded file --}}
                                    @foreach ($errors->get('other_image.*') as $message)
                                        {{ $message[0] }}<br>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Publication Status</label>
                            <div class="col-md-9">
                                <label><input name="status" type="radio" checked value="1">Published</label>
                                <label><input name="status" type="radio" value="0">Unpublished</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Create New Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
