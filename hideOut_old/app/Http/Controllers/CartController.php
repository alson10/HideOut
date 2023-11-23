<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
class CartController extends Controller
{
    public function index()
    {
        // Fetch the user's cart items
        $cartItems = auth()->user()->cartItems; // Assuming you have a relationship set up between User and CartItem models

        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request, Product $product)
    {
        // Check if the product is already in the cart, if so, update the quantity
        $existingCartItem = auth()->user()->cartItems()->where('product_id', $product->id)->first();

        if ($existingCartItem) {
            $existingCartItem->update([
                'quantity' => $existingCartItem->quantity + $request->quantity,
            ]);
        } else {
            // Add the product to the cart
            auth()->user()->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
            
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }
    // public function addToCart(Request $request, $productId)
    // {
    //     // Find the product by ID
    //     $product = Product::find($productId);

    //     // Check if the product exists
    //     if (!$product) {
    //         return redirect()->back()->with('error', 'Product not found.');
    //     }

    //     // Check if the user already has this product in their cart
    //     $existingCartItem = CartItem::where('user_id', auth()->user()->id)
    //         ->where('product_id', $productId)
    //         ->first();

    //     if ($existingCartItem) {
    //         // Update the quantity if the product is already in the cart
    //         $existingCartItem->increment('quantity'); // You can modify this logic as needed
    //     } else {
    //         // Create a new cart item if the product is not in the cart
    //         CartItem::create([
    //             'user_id' => auth()->user()->id,
    //             'product_id' => $productId,
    //             'quantity' => 1, // You can modify this initial quantity as needed
    //         ]);
    //     }

    //     return redirect()->route('cart.view')->with('success', 'Product added to cart.');
    // }
// public function addToCart(Product $product)
// {
//     // Here, you can add the selected product to the user's cart
//     // You may want to store cart data in your database or session

//     // For simplicity, we'll assume you have a session-based cart
//     $cart = session()->get('cart', []);

//     // Add the product to the cart
//     $cart[$product->id] = $product;

//     // Save the updated cart back to the session
//     session()->put('cart', $cart);

//     return response()->json(['message' => 'Product added to cart']);
// }

public function update(Request $request, $id)
{
    $cartItem = CartItem::find($id);

    if ($cartItem) {
        $cartItem->update([
            'quantity' => $request->input('quantity')
        ]);

        return redirect()->back()->with('success', 'Quantity updated successfully!');
    }

    return redirect()->back()->with('error', 'Failed to update quantity.');
}




    public function updateCart(Request $request)
    {
        foreach ($request->input('cart_items') as $cartItemId => $quantity) {
            // Update cart item quantities
            $cartItem = CartItem::findOrFail($cartItemId);
            $cartItem->update([
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

    public function removeCartItem(CartItem $cartItem)
    {
        // Remove a cart item
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }
    

    public function calculateTotal()
    {
        $total = auth()->user()->cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        return $total;
    }
//     public function remove(CartItem $cartItem)
// {
//     // Ensure that the cart item belongs to the currently authenticated user
//     if ($cartItem->user_id !== auth()->user()->id) {
//         abort(403, 'Unauthorized');
//     }
    

//     // Delete the cart item
//     $cartItem->delete();

//     return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
// }
public function remove(CartItem $cartItem)
{
    // Ensure that the cart item belongs to the currently authenticated user
    if ($cartItem->user_id !== auth()->user()->id) {
        abort(403, 'Unauthorized');
    }

    // Delete the cart item
    $cartItem->delete();

    return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
}

}
