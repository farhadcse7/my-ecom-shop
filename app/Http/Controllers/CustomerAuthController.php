<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Session;

class CustomerAuthController extends Controller
{
    private $customer;

    public function register()
    {
        return view('customer.register');
    }

    public function store(Request $request)
    {
        // return $request;
        $this->customer = Customer::newCustomer($request);
        Session::put('customer_id', $this->customer->id);
        Session::put('customer_name', $this->customer->name);

        return redirect('/checkout/confirm-order');
    }

    public function dashboard()
    {
        return view('customer.dashboard');
    }

    public function login()
    {
        return view('customer.login');
    }

    public function loginCheck(Request $request)
    {
        //return $request;
        $this->customer = Customer::where('email', $request->email)->first();

        if ($this->customer) {
            if (password_verify($request->password, $this->customer->password)) {
                Session::put('customer_id', $this->customer->id);
                Session::put('customer_name', $this->customer->name);
                if (isset($request->check_page) && $request->check_page == 'dashboard') {
                    return redirect('/customer/dashboard');
                }
                return redirect('/checkout/confirm-order');
            } else {
                return back()->with('message', 'Sorry ... Your password is not valid');
            }
        } else {
            return back()->with('message', 'Sorry... Your email is not valid');
        }
    }


    public function logout()
    {
        Session::forget('customer_id');
        Session::forget('customer_name');
        return redirect('/');
    }

}
