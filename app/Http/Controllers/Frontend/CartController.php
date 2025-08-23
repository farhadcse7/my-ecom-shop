<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    private $product;

    public function index()
    {
        // return  Cart::content(); //without passing Cart::content() as variable we can use into file as it's global
        return view('website.cart.index', ['cart_products' => Cart::content()]);
    }

    public function add(Request $request, $id)
    {
        //return $request;

        $this->product = Product::find($id);

        $options = [
            'image' => $this->product->image,
            'code'  => $this->product->code,
            'color' => $request->color ?? 'NA', // Default to "NA" if color is not provided
            'size'  => $request->size ?? 'NA', // Default to "NA" if size is not provided
        ];

        // Add color and size if provided
        //        if ($request->filled('color')) {
        //            $options['color'] = $request->color;
        //        }
        //        if ($request->filled('size')) {
        //            $options['size'] = $request->size;
        //        }

        Cart::add([
            'id'      => $id,
            'name'    => $this->product->name,
            'qty'     => $request->qty ?? 1, // Default to 1 if qty is not provided
            'price'   => $this->product->selling_price,
            'weight'  => 0,
            'options' => $options,
        ]);

        // return redirect()->route('cart.show')->with('message', 'Cart product info add successfully');
        // return redirect()->back()->with('success', 'Cart product info add successfully');

        // Check which button was clicked
        if ($request->action === 'buy_now') {
            return redirect()->route('cart.show')
                ->with('success', 'Product added. Redirecting to cart...');
        }

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function update(Request $request, $rowId)
    {
        Cart::update($rowId, $request->qty);
        // return redirect()->route('cart.show')->with('success', 'Cart product info update successfully');
        return redirect()->back()->with('success', 'Cart product info update successfully');
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        // return redirect()->route('cart.show')->with('success', 'Cart product info remove successfully');
        return redirect()->back()->with('success', 'Cart product info remove successfully');
    }
}
