<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
//     public function index()
// {
//     $products = Product::all();
//     return view('products.index', compact('products'));
// }
public function index()
{
    $products = Product::orderBy('created_at', 'desc')->paginate(10);

    return view('products.index', compact('products'));
}


public function getPackages()
{
    $packages = Product::where('category', 'packages')->get();
    return view('welcome', compact('packages'));
}



public function create()
{
    return view('products.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'category' => 'required',
        'quantity' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload and store logic (assuming 'image' field is a file upload)
    $productData = $request->except('image');

    if ($request->hasFile('image')) {
      
        $imagePath = $request->file('image')->store('product_images', 'public');
        // $imagePath = storage_path('app/public/' . $imagePath1);
        $productData['image_path'] = $imagePath;
        
    }
    // $imagePath = $request->file('image')->store('images'); // Adjust the storage path as needed

    $product = new Product();
    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->category = $request->input('category');
    $product->quantity = $request->input('quantity');
    $product->image_path = $imagePath; // Store the uploaded image path

    $product->save();

    // Redirect or return a response after saving the product
    return redirect()->route('products.index')->with('success', 'Product created successfully');

}


public function edit(Product $product)
{
    return view('products.edit', compact('product'));
}

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Use 'sometimes' to allow updating without a new image
        ]);

        // Update product fields
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->category = $validatedData['category'];
        $product->quantity = $validatedData['quantity'];

        // Update image only if a new one is provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            $productData['image_path'] = $imagePath;
        }
        

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
