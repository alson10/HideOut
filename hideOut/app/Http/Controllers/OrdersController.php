<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\CartItem;
class OrdersController extends Controller
{

    public function index(Request $request)
    {
        // Retrieve orders for the authenticated user
        $query = Order::where('user_id', auth()->user()->id);
    
        // Search by order status
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('status', 'like', '%' . $searchTerm . '%');
        }
    
        $orders = $query->get();
    
        return view('orders.index', ['orders' => $orders]);
    }
    
    // public function index()
    // {
    //     // Retrieve orders for the authenticated user
    //     $orders = Order::where('user_id', auth()->user()->id)->get();

    //     return view('orders.index', ['orders' => $orders]);
    // }
    public function cancel(Request $request, Order $orders)
    {
        // Add logic to cancel the order
        $orders->status = 'cancelled';
        $orders->save();

        // Revert product quantities
        foreach ($orders->orderItems as $orderItem) {

            $product = Product::find($orderItem->product_id);
            if ($product) {
                $product->quantity += $orderItem->quantity;
                $product->save();
            }
        }

        return redirect()->route('orders.index')->with('success', 'Order has been cancelled.');
    } 



    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'contact' => 'required|string',
            'delivery' => 'required|string',
            'address' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $order = new Order();
            $order->contact = $validatedData['contact'];
            $order->delivery = $validatedData['delivery'];
            $order->address = $validatedData['address'] ?? null;
            $order->message = $validatedData['message'] ?? null;
            $order->user_id = Auth::id();
            $order->save();

            $cartItems = auth()->user()->cartItems;

            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem([
                    'product_id' => $cartItem->product->id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'image_path' => $cartItem->product->image_path,
                ]);

                $order->orderItems()->save($orderItem);

                // Subtract the quantity of the product
                $cartItem->product->decrement('quantity', $cartItem->quantity);
            }

            auth()->user()->cartItems()->delete();
            // dd($order);
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order created.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Error processing the order. Please try again.');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
