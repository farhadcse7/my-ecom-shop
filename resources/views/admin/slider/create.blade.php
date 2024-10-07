@extends('admin.master')
@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Slider Module</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Slider</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Slider</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">Create Slider Form</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{session('message')}}</p>
                    <form class="form-horizontal" action="{{route('slider.store')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row mb-4">
                            <label for="categoryName" class="col-md-3 form-label">Slider Heading</label>
                            <div class="col-md-9">
                                <input class="form-control" name="heading" id="categoryName" placeholder="Slider Heading" type="text">
                                <span class="text-danger">{{$errors->has('heading') ? $errors->first('heading') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="categoryDescription" class="col-md-3 form-label">Slider Title</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="title" id="categoryDescription" placeholder="Slider Title"></textarea>
                                <span class="text-danger">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="categoryDescription" class="col-md-3 form-label">Slider Sub Title</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="sub_title" id="categoryDescription" placeholder="Slider Sub Title"></textarea>
                                <span class="text-danger">{{$errors->has('sub_title') ? $errors->first('sub_title') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="image" class="col-md-3 form-label">Slider Image</label>
                            <div class="col-md-9">
                                <input class="form-control" name="image" id="image" type="file">
                                <span class="text-danger">{{$errors->has('image') ? $errors->first('image') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="categoryDescription" class="col-md-3 form-label">Slider Button Text</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="button_text" id="categoryDescription" placeholder="Slider Button Text"></textarea>
                                <span class="text-danger">{{$errors->has('button_text') ? $errors->first('button_text') : ''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="categoryDescription" class="col-md-3 form-label">Slider Button Link</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="button_link" id="categoryDescription" placeholder="Slider Button Link"></textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Publication Status</label>
                            <div class="col-md-9">
                                <label><input name="status" type="radio" checked value="1">Published</label>
                                <label><input name="status" type="radio" value="0">Unpublished</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Create New Slider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
