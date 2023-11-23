<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Earning;
use App\Models\Product;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    // public function index()
    // {
    //     dd('Controller hit'); // Add this line
    //     $totalUsers = User::count();
    //     $totalEarnings = Earning::sum('amount');
    //     $totalProducts = Product::count();
    //     $totalOrders = Order::count();

    //     return view('dashboard.index', compact('totalUsers', 'totalEarnings', 'totalProducts', 'totalOrders'));
    // }
    // public function index()
    // {
    //     $totalUsers = User::count();
    //     $totalEarnings = Earning::sum('amount');
    //     $totalProducts = Product::count();
    //     $totalOrders = Order::count();
    

    //     return view('dashboard.index', compact('totalProducts'));
    // }
    

}
