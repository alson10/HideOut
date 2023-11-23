
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/dulaypartyneeds.png') }}" type="">
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <main>
       <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container mx-auto">
                    <div class="max-w-md mx-auto my-10 bg-white p-6 rounded-md shadow-md">
                        <div class="text-xl font-semibold mb-4">Edit Product</div>

                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                                <select name="category" id="category" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="" disabled>Select Category</option>
                                    <option value="Brandy" {{ $product->category === 'Brandy' ? 'selected' : '' }}>Brandy</option>
                                    <option value="Gin"  {{ $product->category === 'Gin' ? 'selected' : '' }} >Gin</option>
                                    <option value="Rum" {{ $product->category === 'Rum' ? 'selected' : '' }} >Rum</option>
                                    <option value="Tequila" {{ $product->category === 'Tequila' ? 'selected' : '' }} >Tequila</option>
                                    <option value="Vodka" {{ $product->category === 'Vodka' ? 'selected' : '' }} >Vodka</option>
                                    <option value="Whiskey" {{ $product->category === 'Whiskey' ? 'selected' : '' }} >Whiskey</option>
                                    <option value="Pulutan" {{ $product->category === 'Pulutan' ? 'selected' : '' }} >Pulutan</option>
                                </select>
                                @error('category')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <div class="mb-4">
                                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                                <select name="category" id="category" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="" selected disabled>Select Category</option>
                                    <option value="balloons">Balloons</option>
                                    <option value="banners">Party Banners</option>
                                    <option value="cakes">Cakes</option>
                                    <option value="flowers">Flowers</option>
                                    <option value="chocolates">Chocolates</option>
                                    <option value="packages">Packages</option>
                                </select>
                                @error('category')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div> -->
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $product->name }}">
                                @error('name')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                <textarea name="description" id="description" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $product->description }}"></textarea>
                                @error('description')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div> -->
                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                <textarea name="description" id="description" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $product->description }}</textarea>
                                @error('description')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                                <input type="number" name="price" id="price" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $product->price }}">
                                @error('price')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantity Available:</label>
                                <input type="number" name="quantity" id="quantity" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ $product->quantity }}">
                                @error('quantity')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- <div class="mb-4">
                                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                                <input type="file" name="image" id="image" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ $product->image_path }}">
                                @error('image')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div> -->
                            <div class="mb-4">
                                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Current Image:</label>
                                <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" style="max-width: 200px; max-height: 200px;">
                                @error('image')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">New Image:</label>
                                <input type="file" name="image_path" id="image" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm">
                                @error('image')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" style="background-color: blue;color: white; padding: 10px;" >Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
</body>
</html>