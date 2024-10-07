<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.home.index', [
            'total_customers'   => count(Customer::all()),
            'total_products'    => count(Product::all()),
            'total_brands'      => count(Brand::all()),
            'total_orders'      => count(Order::all()),
            'total_today_order' => count(Order::where('order_date', date('Y-m-d'))->get())
        ]);
    }
}
