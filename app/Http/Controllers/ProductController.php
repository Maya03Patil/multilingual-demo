<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Show the e-commerce storefront.
     */
    public function index()
    {
        $products = get_mock_products();
        return view('welcome', compact('products'));
    }

    /**
     * Store a new product in the session-based mock database.
     */
    public function store(Request $request)
    {
        $products = get_mock_products();
        
        $newProduct = (object) [
            'id' => count($products) + 1,
            'name' => $request->name,
            'description' => $request->description,
            'price' => (float) $request->price,
            'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=400'
        ];

        $products[] = $newProduct;
        Session::put('demo_products', $products);

        return redirect()->route('products.index')->with('success', 'Product added successfully! It will now be auto-translated across the site.');
    }
}
