<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Session::get('customer_id')) {
            return redirect('/checkout/confirm-order');
        }

        return view('website.checkout.index');
    }

    public function confirmOrder()
    {
        return view('website.checkout.confirm-order');
    }

}
