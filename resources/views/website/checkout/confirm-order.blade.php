@extends('website.master')
@section('title')
    Checkout Page
@endsection

@section('body')
    <!-- breadcrumb area start -->
    <section class="breadcrumb__area include-bg pt-95 pb-50" data-bg-color="#EFF1F5">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="breadcrumb__content p-relative z-index-1">
                        <h3 class="breadcrumb__title">Checkout</h3>
                        <div class="breadcrumb__list">
                            <span><a href="#">Home</a></span>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb area end -->

    <!-- checkout area start -->
    <section class="tp-checkout-area pb-120" data-bg-color="#EFF1F5">
        <div class="container">
            <div class="row">
                <!-- Deliviery address side -->
                <div class="col-lg-7">
                    <div class="tp-checkout-bill-area">
                        <h3 class="tp-checkout-bill-title">Billing Details</h3>
                        <div class="tp-checkout-bill-form">
                            <div class="tp-checkout-bill-inner">
                                <form action="{{route('checkout.new-order')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="">
                                                <label>Street address <span>*</span></label>
                                                <textarea name="delivery_address" id="text-area" placeholder="Delivery Address" class="form-control" style="height: 100px"></textarea>
                                                <span class="text-danger">{{$errors->has('delivery_address') ? $errors->first('delivery_address') : ''}}</span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="tp-checkout-option-wrapper">
                                                <div class="">
                                                    <input id="checkbox-3" type="radio" name="payment_method" value="cash" checked>
                                                    <label for="checkbox-3">Cash On Delivery</label>
                                                </div>
                                                <div class="">
                                                    <input id="checkbox-4" type="radio" name="payment_method" value="online">
                                                    <label for="checkbox-4">Online</label>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="shipping" value="" id="hiddenShipping">
                                        <div class="tp-login-bottom">
                                            <button type="submit" class="tp-checkout-btn w-30">Confirm Order</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order side -->
                <div class="col-lg-5">
                    <!-- checkout place order -->
                    <div class="tp-checkout-place white-bg">
                        <h3 class="tp-checkout-place-title">Your Order</h3>
                        <div class="tp-order-info-list">
                            <ul>
                                <!-- header -->
                                <li class="tp-order-info-list-header">
                                    <h4>Product</h4>
                                    <h4>Total</h4>
                                </li>
                                <!-- item list -->
                                @php($sum=0)
                                @foreach(Cart::content() as $item)
                                    <li class="tp-order-info-list-desc">
                                        <p>{{$item->name}} <span> x {{$item->qty}}</span></p>
                                        <p class="ms-auto">({{$item->price}} x {{$item->qty}})</p>
                                        <span class="ps-5 ms-5">{{$item->price * $item->qty}}</span>
                                    </li>
                                    @php($sum=$sum+($item->price * $item->qty))
                                @endforeach
                            <!-- subtotal -->
                                <li class="tp-order-info-list-subtotal">
                                    <span>Subtotal</span>
                                    <span>{{$sum}}</span>
                                </li>
                                <li class="tp-order-info-list-subtotal">
                                    <span>Tax Amount (15%)</span>
                                    <span>{{$tax=round($sum * 0.15)}}</span>
                                </li>
                                <!-- shipping -->
                                <li class="tp-order-info-list-shipping">
                                    <span>Shipping</span>
                                    <div class="tp-order-info-list-shipping-item d-flex flex-column align-items-end">
                                    <span>
                                       <input id="flat_rate" type="radio" name="shipping" value="100">
                                       <label for="flat_rate">Outside Dhaka: <span>TK. 100</span></label>
                                    </span>
                                        <span>
                                       <input id="local_pickup" type="radio" name="shipping" value="50">
                                       <label for="local_pickup">Inside Dhaka: <span>TK. 50</span></label>
                                    </span>
                                        <span>
                                       <input id="free_shipping" type="radio" name="shipping" value="0" checked>
                                       <label for="free_shipping">Free shipping</label>
                                    </span>
                                    </div>
                                </li>
                                <!-- total -->
                                <li class="tp-order-info-list-total">
                                    <span>Total</span>
                                    @php($shipping=0)
                                    <span id="total_amount">TK. {{$totalPayable=$sum+$tax+$shipping}}</span>
                                </li>
                                <?php
                                Session::put('order_total', $totalPayable);
                                Session::put('tax_amount', $tax);
                                //  Session::put('shipping_amount', $shipping);
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- checkout area end -->

    <!-- js script for shipping amount start-->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Define the sum and tax values from Laravel
            let sum = {{$sum}};
            let tax = {{$tax}};
            let shippingCost = {{$shipping}};

            // Function to calculate and update the total
            function updateShippingCost() {
                document.getElementById('hiddenShipping').value = shippingCost;
            }

            // Set initial total with default shipping cost
            updateShippingCost();

            // Listen for changes to the radio buttons
            document.querySelectorAll('input[name="shipping"]').forEach(function (input) {
                let shippingCost = 0;
                input.addEventListener('change', function () {
                    // Get the selected shipping value
                    let shippingCost = parseFloat(this.value);

                    // Calculate the new total
                    let total = sum + tax + shippingCost;

                    // Update the total in the DOM
                    document.getElementById('total_amount').innerText = 'TK. ' + total;
                    document.getElementById('hiddenShipping').value = shippingCost;
                });
            });
        });
    </script>
    <!-- js script for shipping amount end-->
@endsection
