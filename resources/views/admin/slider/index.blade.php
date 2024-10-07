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
                <li class="breadcrumb-item active" aria-current="page">Manage Slider</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- DataTable -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h3 class="card-title">All Slider Info</h3>
                </div>
                <div class="card-body">
                    <p id="sessionMessage" class="text-muted">{{session('message')}}</p>
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">Heading</th>
                                <th class="wd-15p border-bottom-0">Title</th>
                                <th class="wd-20p border-bottom-0">Sub Title</th>
                                <th class="wd-15p border-bottom-0">Image</th>
                                <th class="wd-10p border-bottom-0">Button Text</th>
                                <th class="wd-10p border-bottom-0">Button Link</th>
                                <th class="wd-10p border-bottom-0">Status</th>
                                <th class="wd-25p border-bottom-0">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>{{$slider->heading}}</td>
                                    <td>{{$slider->title}}</td>
                                    <td>{{$slider->sub_title}}</td>
                                    <td><img src="{{asset($slider->image)}}" alt="" height="50"></td>
                                    <td>{{$slider->button_text}}</td>
                                    <td>{{$slider->button_link}}</td>
                                    <td>{{$slider->status==1 ? 'Published':'Unpublished'}}</td>
                                    <td>
                                        <a href="{{route('slider.edit', $slider->id)}}" class="btn btn-success btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{route('slider.destroy', $slider->id)}}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End DataTable -->

@endsection
