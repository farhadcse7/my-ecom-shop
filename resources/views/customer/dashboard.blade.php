@extends('website.master')
@section('title')
    My Dashboard
@endsection

@section('body')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg text-center pt-95 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Dashboard</h3>
                        <div class="breadcrumb__list">
                            <span><a href="#">Home</a></span>
                            <span>Dashboard</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <!-- login area start -->
    <section class="tp-login-area pb-140 p-relative z-index-1 fix">
        <div class="tp-login-shape">
            <img class="tp-login-shape-1" src="assets/img/login/login-shape-1.png" alt="">
            <img class="tp-login-shape-2" src="assets/img/login/login-shape-2.png" alt="">
            <img class="tp-login-shape-3" src="assets/img/login/login-shape-3.png" alt="">
            <img class="tp-login-shape-4" src="assets/img/login/login-shape-4.png" alt="">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col">
                    <h1>My Dashboard</h1>
                    <hr>
                    <h4>My Recent Order</h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>SL NO</th>
                            <th>Order ID</th>
                            <th>Order Total</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$order->id}}</td>
                                <td>{{$order->order_total}}</td>
                                <td>{{$order->order_date}}</td>
                                <td>{{$order->order_status}}</td>
                                <td>{{$order->payment_status}}</td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm">Detail</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- login area end -->
@endsection