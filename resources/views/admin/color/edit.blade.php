@extends('admin.master')
@section('body')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Color Module</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Color</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Color</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">Update Color Form</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{session('message')}}</p>
                    <form class="form-horizontal" action="{{route('color.update', $color->id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="row mb-4">
                            <label for="colorName" class="col-md-3 form-label">Color Name</label>
                            <div class="col-md-9">
                                <input class="form-control" name="name" value="{{$color->name}}" id="colorName"
                                       placeholder="Color Name" type="text">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="colorCode" class="col-md-3 form-label">Color Code</label>
                            <div class="col-md-3">
                                <input class="form-control" name="code" value="{{$color->code}}" id="colorCode"
                                       placeholder="Color Code" type="color">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="colorDescription" class="col-md-3 form-label">Color Description</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="description" id="colorDescription"
                                          placeholder="Color Description">{{$color->description}}</textarea>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-md-3 form-label">Publication Status</label>
                            <div class="col-md-9">
                                <label><input name="status" type="radio" {{$color->status==1 ? 'checked':''}} value="1">Published</label>
                                <label><input name="status" type="radio" {{$color->status==0 ? 'checked':''}} value="0">Unpublished</label>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Update Color</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
