<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalEarnings = Order::where('status', 'delivered')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->sum(\DB::raw('order_items.price * order_items.quantity'));
       
        return view('dashboard.index', compact('totalProducts','totalUsers', 'totalOrders','totalEarnings'));
    }

    
}
