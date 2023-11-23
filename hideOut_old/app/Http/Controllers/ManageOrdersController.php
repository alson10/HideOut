<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
class ManageOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $orders = Order::all();

        // return view('manageOrders.index', compact('orders'));
        $orders = Order::all(); // Fetch orders from the database or any method you use

         return view('manageOrders.index', ['orders' => $orders]);
    }
    // public function updateStatus(Request $request, $orderId) {
    //     $order = Order::find($orderId);
    //     $order->status = $request->status; // Assuming the status is sent in the request
    //     $order->save();
    
    //     // Redirect back or to a specific page after the update
    //     return redirect()->back()->with('success', 'Order status updated successfully');
    // }
    public function updateStatus(Request $request, $orderId) {
        $order = Order::find($orderId);
    
        if ($order->status !== 'Cancelled') {
            $order->status = $request->status; // Assuming the status is sent in the request
            $order->save();
    
            return redirect()->back()->with('success', 'Order status updated successfully');
        } else {
            return redirect()->back()->with('error', 'Cannot update status for a Cancelled order');
        }
    }
    
    // public function updateStatus(Request $request, $orderId) {
    //     $order = Order::find($orderId);
    
    //     if ($order) {
    //         if ($request->has('status') && $request->status !== null) {
    //             $order->status = $request->status;
    //             $order->save();
    //             return redirect()->back()->with('success', 'Order status updated successfully');
    //         } else {
    //             return redirect()->back()->with('error', 'Status cannot be empty');
    //         }
    //     } else {
    //         return redirect()->back()->with('error', 'Order not found');
    //     }
    // }
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
