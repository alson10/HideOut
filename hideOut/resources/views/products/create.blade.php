
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
                        <div class="text-xl font-semibold mb-4">Add Product</div>

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Add a category select dropdown -->
                            <div class="mb-4">
                                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                                <select name="category" id="category" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="" selected disabled>Select Category</option>
                                    <option value="Brandy">Brandy</option>
                                    <option value="Gin">Gin</option>
                                    <option value="Rum">Rum</option>
                                    <option value="Tequila">Tequila</option>
                                    <option value="Vodka">Vodka</option>
                                    <option value="Whiskey">Whiskey</option>
                                    <option value="Pulutan">Pulutan</option>
                                    <option value="Package">Package</option>
                                </select>
                                <!-- Validation Error Message (if applicable) -->
                                @error('category')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" >
                                @error('name')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                <textarea name="description" id="description" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" ></textarea>
                                @error('description')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                                <input type="number" name="price" id="price" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" >
                                @error('quantity')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Quantity Available:</label>
                                <input type="number" name="quantity" id="quantity" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" >
                                @error('quantity')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                                <input type="file" name="image_path" id="image" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm">
                                @error('image')
                                    <div class="text-red-600 text-sm">{{ $message }}</div>
                                @enderror
                            </div>


                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" style="background-color: blue;color: white; padding: 10px;">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
</body>
</html>