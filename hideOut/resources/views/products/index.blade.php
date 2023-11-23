
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/dulaypartyneeds.png') }}" type="">
        <!-- Include Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg inline-block" style="background-color: blue;color: white; padding: 10px;">+ Product</a>

                @if(session('success'))
                    <div class="bg-green-100 border-green-200 text-green-700 rounded-lg px-4 py-2" >
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            
            <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold ">Product List</h3>
                        <form action="{{ route('products.index') }}" method="GET" class="flex">
                            <select name="month" class="mr-2">
                                <option value="">Select Month</option>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ Request::input('month') == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="year" class="mr-2">
                                <option value="">Select Year</option>
                                @foreach (range(date('Y'), date('Y')+20) as $year)
                                    <option value="{{ $year }}" {{ Request::input('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="search" placeholder="Search..." class="mr-2" value="{{ Request::input('search') }}">
                            <button type="submit" class="bg-blue-500 px-4 py-2 rounded-lg">Search</button>
                        </form>
                    </div>
        @if ($products->count() > 0)
        
        <table class="w-full border border-gray-200">
            <thead>
                <tr>
                <th class="px-4 py-2 bg-gray-100 border">Image</th>
                    <th class="px-4 py-2 bg-gray-100 border">Name</th>
                    <th class="px-4 py-2 bg-gray-100 border">Description</th>
                    <th class="px-4 py-2 bg-gray-100 border">Price</th>
                    <th class="px-4 py-2 bg-gray-100 border">Category</th>
                    <th class="px-4 py-2 bg-gray-100 border">Stock</th>
                    <th class="px-4 py-2 bg-gray-100 border">Date Added</th>
                    <th class="px-4 py-2 bg-gray-100 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr class="text-center">
                        <td class="px-4 py-2 border">
                            <center>
                                <img src="{{ $item->image_path }}" style="max-width: 100px; height: auto;">
                              
                            </center>
                        </td>
                        
                        <td class="px-4 py-2 border">{{ $item->name }} </td>
                        <td class="px-4 py-2 border">{{ $item->description }}</td>
                        <td class="px-4 py-2 border">{{ $item->price }}</td>
                        <td class="px-4 py-2 border">{{ $item->category }}</td>
                        <td class="px-4 py-2 border">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</td>
                        
                        <td class="px-4 py-2 border">
                            <div class="d-flex justify-content-between">
                                <div class="col">
                                    <a href="{{ route('products.edit', $item->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="col">
                                    <form action="{{ route('products.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <h5>You have no products</h5>
                    @endif
                </div>
            </div>
        </div>   
    </div>
</x-app-layout>
</body>
</html>