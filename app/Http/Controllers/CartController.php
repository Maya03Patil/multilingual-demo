<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * View the cart page.
     */
    public function index()
    {
        $cart = Session::get('demo_cart', []);
        return view('cart', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $cart = Session::get('demo_cart', []);
        
        $item = [
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'qty' => 1
        ];

        // Ensure duplication check
        $exists = false;
        foreach ($cart as &$cartItem) {
            if ($cartItem['id'] == $item['id']) {
                $cartItem['qty']++;
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $cart[] = $item;
        }

        Session::put('demo_cart', $cart);

        return redirect()->back()->with('success', 'Added to cart!');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        Session::forget('demo_cart');
        return redirect()->back();
    }
}
