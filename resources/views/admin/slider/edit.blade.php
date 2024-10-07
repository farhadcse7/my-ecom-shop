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
                <li class="breadcrumb-item active" aria-current="page">Edit Slider</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">Edit Slider Form</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{session('message')}}</p>
                    <form class="form-horizontal" action="{{route('slider.update', $slider->id)}}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('put')
                        <div class="row mb-4">
                            <label for="brandName" class="col-md-3 form-label">Slider Heading</label>
                            <div class="col-md-9">
                                <input class="form-control" name="heading" value="{{$slider->heading}}" id="brandName" placeholder="Slider Heading" type="text">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="brandDescription" class="col-md-3 form-label">Slider Title</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="title" id="brandDescription" placeholder="Slider Title">{{$slider->title}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="brandDescription" class="col-md-3 form-label">Slider Sub Title</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="sub_title" id="brandDescription" placeholder="Slider Title">{{$slider->sub_title}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="image" class="col-md-3 form-label">Slider Image</label>
                            <div class="col-md-9">
                                <input class="form-control" name="image" id="image" type="file">
                                <img src="{{asset($slider->image)}}" alt="" height="100">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="brandDescription" class="col-md-3 form-label">Slider Button Text</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="button_text" id="brandDescription" placeholder="Slider Button Text">{{$slider->button_text}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="brandDescription" class="col-md-3 form-label">Slider Button Link</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="button_link" id="brandDescription" placeholder="Slider Title">{{$slider->button_link}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Publication Status</label>
                            <div class="col-md-9">
                                <label><input name="status" type="radio" {{$slider->status==1 ? 'checked':''}} value="1">Published</label>
                                <label><input name="status" type="radio" {{$slider->status==0 ? 'checked':''}} value="0">Unpublished</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update Slider Info</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
