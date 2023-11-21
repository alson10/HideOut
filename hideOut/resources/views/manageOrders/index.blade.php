<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/images/dulaypartyneeds.png') }}" type="">
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Orders') }}
        </h2>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            
            <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold ">Orders List</h3>
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
        @if ($orders && count($orders) > 0)

                    <table class="w-full border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-100 border">Order ID</th>
                                <th class="px-4 py-2 bg-gray-100 border">User ID</th>
                                <th class="px-4 py-2 bg-gray-100 border">Contact</th>
                                <th class="px-4 py-2 bg-gray-100 border">Address</th>
                                <th class="px-4 py-2 bg-gray-100 border">Delivery</th>
                                <th class="px-4 py-2 bg-gray-100 border">Status</th>
                                <th class="px-4 py-2 bg-gray-100 border">Date Ordered</th>
                                <th class="px-4 py-2 bg-gray-100 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $order->id }}</td>
                                    <td class="px-4 py-2 border">{{ $order->user_id }}</td>
                                    <td class="px-4 py-2 border">{{ $order->contact }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ $order->address }}
                                    </td>
                                     <td class="px-4 py-2 border">
                                        {{ $order->delivery }}
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <!-- Replace with status information -->
                                        <p> {{ $order->status }}</p>
                                    </td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y H:i:s') }}</td>
                                    <td class="px-4 py-2 border">
                                    <div class="d-flex justify-content-between">
                                        <div class="col">
                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#orderInfoModal{{ $order->id }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $order->id }}">
                                                <i class="fas fa-edit"></i> 
                                            </button>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            <!-- Modal for updating the order status -->
            @foreach ($orders as $order)
            @if ($order->status !== 'cancelled')
            <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateStatusModalLabel">Update Order Status</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route('update-status', ['orderId' => $order->id]) }}">
                                @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="statusSelect">Select Status:</label>
                                    <select class="form-select" name="status" id="statusSelect">
                              
                                        <option value="delivered">Delivered</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                
                                    <button  class="btn btn-primary">Update Status</button>
                            </form>
                                <!-- <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
            <!-- Modals for order information -->
            @foreach ($orders as $order)
                <div class="modal fade" id="orderInfoModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderInfoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="orderInfoModalLabel">Order Information</h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card mb-4">
                                    <div class="card-header">Order ID: {{ $order->id }}</div>
                                    <div class="card-body">
                                    @php
                                    $totalAmount = 0;
                                @endphp
                                        @foreach ($order->orderItems as $orderItem)
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <img src="{{ asset('storage/' . $orderItem->image_path) }}" alt="Product Image" width="60px">
                                                </div>
                                                <div class="col-md-4">
                                                    <p>{{ $orderItem->product_name }}</p>
                                                    <p>₱{{ $orderItem->price }}</p>
                                                    <p>Quantity: {{ $orderItem->quantity }}</p>
                                                    @php
                                                $totalAmount += $orderItem->price * $orderItem->quantity;
                                                @endphp
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                    <p>Total Amount: ₱{{ $totalAmount }}</p>
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
            @else
            <div class="alert alert-info text-center">
                You have no orders.
            </div>
        @endif
    </div>
    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Include Font Awesome JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</x-app-layout>
</body>
</html>
