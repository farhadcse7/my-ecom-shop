@extends('website.master')
@section('title')
    Shopping Cart Page
@endsection

@section('body')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-95 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Shopping Cart</h3>
                        <div class="breadcrumb__list">
                            <span><a href="{{route('home')}}">Home</a></span>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <!-- cart area start -->
    <section class="tp-cart-area pb-120">
        <div class="container">
            <h6 class="text-success">{{session('message')}}</h6>
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="tp-cart-list mb-25 mr-30">
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2" class="tp-cart-header-product">Product</th>
                                <th class="tp-cart-header-price">Price</th>
                                <th class="tp-cart-header-quantity">Quantity</th>
                                <th class="tp-cart-header-quantity">Sub Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Cart Table for product list start -->
                            @php($sum=0)
                            @foreach($cart_products as $cart_product)
                                <tr>
                                    <!-- img -->
                                    <td class="tp-cart-img"><a href="">
                                            <img src="{{ asset($cart_product->options->image) }}" alt=""></a>
                                    </td>
                                    <!-- title -->
                                    <td class="tp-cart-title"><a href="">{{$cart_product->name}}</a>
                                        <p style="padding-left: 20px">Code: {{$cart_product->options->code}}</p>
                                    </td>

                                    <!--single price -->
                                    <td class="tp-cart-price"><span>{{$cart_product->price}}</span></td>
                                    <!-- quantity -->
                                    <td class="tp-cart-quantity">
                                        <form action="{{route('cart.update',['rowId'=>$cart_product->rowId])}}" method="post">
                                            @csrf
                                            <div class="tp-product-quantity mt-10 mb-10">
                                            <span class="tp-cart-minus">
                                                <svg width="10" height="2" viewBox="0 0 10 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                                <input class="tp-cart-input" type="text" name="qty" value="{{$cart_product->qty}}">
                                                <span class="tp-cart-plus">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 1V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M1 5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm ms-3">Update</button>
                                        </form>
                                    </td>
                                    <!--subtotal price -->
                                    <td class="tp-cart-price"><span>{{$cart_product->price * $cart_product->qty}}</span>
                                    </td>
                                    <!-- action -->
                                    <td class="tp-cart-action">
                                        <button class="tp-cart-action-btn" onclick="window.location.href='{{ route('cart.remove',['rowId'=>$cart_product->rowId]) }}'">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor"/>
                                            </svg>
                                            <span>Remove</span>
                                        </button>
                                    </td>
                                </tr>
                                @php($sum=$sum+ ($cart_product->price * $cart_product->qty))
                            @endforeach
                            <!-- Cart Table for product list end -->
                            </tbody>
                        </table>
                    </div>
                    <div class="tp-cart-bottom">
                        <div class="row align-items-end">
                            <div class="col-xl-6 col-md-8">
                                <div class="tp-cart-coupon">
                                    <form action="#">
                                        <div class="tp-cart-coupon-input-box">
                                            <label>Coupon Code:</label>
                                            <div class="tp-cart-coupon-input d-flex align-items-center">
                                                <input type="text" placeholder="Enter Coupon Code">
                                                <button type="submit">Apply</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-4">
                                <div class="tp-cart-update text-md-end">
                                    <button type="button" class="tp-cart-update-btn">Update Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="tp-cart-checkout-wrapper">
                        <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                            <span class="tp-cart-checkout-top-title">Subtotal</span>
                            <span class="tp-cart-checkout-top-price">TK. {{$sum}}</span>
                        </div>
                        <div class="tp-cart-checkout-shipping d-flex align-items-center justify-content-between">
                            <span class="tp-cart-checkout-shipping-title">Tax Amount (15%)</span>
                            <span class="tp-cart-checkout-shipping-title">TK. {{$tax=round(($sum*0.15))}}</span>
                        </div>
                        <div class="tp-cart-checkout-shipping">
                            <h4 class="tp-cart-checkout-shipping-title">Shipping</h4>
                            <div class="tp-cart-checkout-shipping-option-wrapper">
                                <div class="tp-cart-checkout-shipping-option">
                                    <input id="flat_rate" type="radio" name="shipping" value="100">
                                    <label for="flat_rate">Outside Dhaka: <span>TK. 100</span></label>
                                </div>
                                <div class="tp-cart-checkout-shipping-option">
                                    <input id="local_pickup" type="radio" name="shipping" value="50">
                                    <label for="local_pickup">Inside Dhaka: <span> TK. 50</span></label>
                                </div>
                                <div class="tp-cart-checkout-shipping-option">
                                    <input id="free_shipping" type="radio" name="shipping" value="0" checked>
                                    <label for="free_shipping">Free shipping: <span>TK. 0</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="tp-cart-checkout-total d-flex align-items-center justify-content-between">
                            <span>Total</span>
                            @php($shipping=0)
                            <span id="total_amount">TK. {{$sum+$tax+$shipping}}</span>
                        </div>
                        <div class="tp-cart-checkout-proceed">
                            <a href="{{ route('checkout') }}" class="tp-cart-checkout-btn w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart area end -->

    <!-- js script for shipping amount start-->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Define the sum and tax values from Laravel
            let sum = {{$sum}};
            let tax = {{$tax}};

            // Listen for changes to the radio buttons
            document.querySelectorAll('input[name="shipping"]').forEach(function (input) {
                input.addEventListener('change', function () {
                    // Get the selected shipping value
                    let shippingCost = parseFloat(this.value);

                    // Calculate the new total
                    let total = sum + tax + shippingCost;

                    // Update the total in the DOM
                    document.getElementById('total_amount').innerText = 'TK. ' + total;
                });
            });
        });
    </script>
    <!-- js script for shipping amount end-->

@endsection

