<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class showProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $products = Product::all(); // Assuming you have a Product model
    //     return view('showProducts.index', compact('showProducts'));
    // }
    // public function index(Request $request)
    // {
        
    //     $products = Product::all();
    //     $query = Product::query();

    //     // Search by name
    //     if ($request->has('search')) {
    //         $searchTerm = $request->input('search');
    //         $query->where('name', 'like', '%' . $searchTerm . '%');
    //     }

    //     return view('showProducts.index', compact('products'));
    // }
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Search by name
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
    
        // Order by latest inserted first
        $query->latest();
    
        $products = $query->get();
    
        return view('showProducts.index', compact('products'));
    }
    
    
    // public function search(Request $request)
    // {
    //     $query = $request->input('query');

    //     // Perform a search query using $query
    //     $results = Product::where('name', 'like', "%$query%")->get();

    //     // Pass the results to the view
    //     return view('showProducts.index', ['results' => $results, 'query' => $query]);
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
