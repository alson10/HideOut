<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $usertype=Auth()->user()->usertype;

            if($usertype=='user')
            {
                $products = Product::all();
                return view('showProducts.index',compact('products'));
            }
            else if($usertype=='admin')
            {
                return view('dashboard.index');
            }
            else
            {
                redirect();
            } 
        }

    }
}
