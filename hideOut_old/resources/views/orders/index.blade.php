<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/images/dulaypartyneeds.png') }}" type="">
</head>
<body>
<x-app-layout>
    <x-slot name="header">
    <div class="d-flex flex-row justify-content-between align-items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Orders') }}
        </h2>
        <!-- <form action="{{ route('orders.index') }}" method="GET" class="d-flex my-2 my-lg-0"> -->
                <!-- <input class="form-control me-sm-2" type="text" placeholder="Search"> -->
                <!-- <input type="text" class="form-control me-sm-2" id="search" name="search" value="{{ request('search') }}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
        </div>
    </x-slot>
    <div class="container mt-4">
        <!-- Navigation bar -->
        <ul class="nav nav-pills nav-fill justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#allOrders">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#pendingOrders">Pending</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#deliveredOrders">Completed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#cancelledOrders">Cancelled</a>
            </li>
        </ul>
        <br>
        <div class="tab-content">
    <div class="tab-pane active" id="allOrders">
        @if ($orders && count($orders) > 0)
            <div class="row justify-content-center">
                <div class="col-md-10">
                    {{-- Display pending orders first --}}
                    @foreach ($orders as $order)
                        @if ($order->status === 'pending')
                            {{-- Pending Order Card --}}
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <p>Status: {{ $order->status }}</p>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#orderInfoModal{{ $order->id }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                        <!-- <div class="col">
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        </div> -->
                                        <div class="col">
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger cancel-order">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- View Info Modal for each order -->
                                    <div class="modal fade" id="orderInfoModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderInfoModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderInfoModalLabel">Order Information</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Include the desired information here -->
                                                    <p>Order ID: {{ $order->id }}</p>
                                                    <p>Contact: {{ $order->contact }}</p>
                                                    <p>Message: {{ $order->message }}</p>
                                                    <p>Delivery: {{ $order->delivery }}</p>
                                                    <p>Date ordered: {{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                    <p>Time ordered: {{ \Carbon\Carbon::parse($order->created_at)->format('h:i:s A') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php
                                        $totalAmount = 0;
                                    @endphp
                                    @foreach ($order->orderItems as $orderItem)
                                        {{-- Order Items --}}
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                @if ($orderItem->image_path)
                                                    <img src="{{ asset('storage/' . $orderItem->image_path) }}" alt="Product Image" style="max-width: 100px">
                                                @else
                                                    No Image
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <p>{{ $orderItem->product_name }}</p>
                                                <br><br>
                                                <p>₱{{ $orderItem->price }} &nbsp;&nbsp;&nbsp;&nbsp; x{{ $orderItem->quantity }}</p>
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
                        @endif
                    @endforeach
                    {{-- Display other statuses (delivered, cancelled, etc.) --}}
                    @foreach ($orders as $order)
                        @if ($order->status !== 'pending')
                            {{-- Other Status Order Cards --}}
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <p>Status: {{ $order->status }}</p>
                                    </div>
                                    <div>
                                        <button  class="btn btn-info" data-bs-toggle="modal" data-bs-target="#orderInfoMod{{ $order->id }}">
                                            <i class="fas fa-info-circle"></i> 
                                        </button>
                                    </div>
                                    <!-- View Info Modal for each order -->
                                    <div class="modal fade" id="orderInfoMod{{ $order->id }}" tabindex="-1" aria-labelledby="orderInfoModLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="orderInfoModLabel">Order Information</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Include the desired information here -->
                                                    <p>Order ID: {{ $order->id }}</p>
                                                    <p>Address: {{ $order->address }}</p>
                                                    <p>Contact: {{ $order->contact }}</p>
                                                    <p>Message: {{ $order->message }}</p>
                                                    <p>Delivery: {{ $order->delivery }}</p>
                                                    <p>Date ordered: {{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                    <p>Time ordered: {{ \Carbon\Carbon::parse($order->created_at)->format(' H:i:s') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php
                                        $totalAmount = 0;
                                    @endphp
                                    @foreach ($order->orderItems as $orderItem)
                                        {{-- Order Items --}}
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                @if ($orderItem->image_path)
                                                    <img src="{{ asset('storage/' . $orderItem->image_path) }}" alt="Product Image" style="max-width: 100px">
                                                @else
                                                    No Image
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <p>{{ $orderItem->product_name }}</p>
                                                <br><br>
                                                <p>₱{{ $orderItem->price }} &nbsp;&nbsp;&nbsp;&nbsp; x{{ $orderItem->quantity }}</p>
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
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                You have no orders.
            </div>
        @endif
    </div>
</div>

            <div class="tab-content">
    @foreach (['pendingOrders','shippedOrders', 'deliveredOrders', 'cancelledOrders'] as $status)
        <div class="tab-pane" id="{{ $status }}">
            @if ($orders && count($orders) > 0)
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        @foreach ($orders as $order)
                            @if ($order->status === str_replace('Orders', '', $status))
                                <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <p>Status: {{ $order->status }}</p>
                                    </div>
                                    <div>
                                        <button  class="btn btn-info" data-bs-toggle="modal" data-bs-target="#orderInfo{{ $order->id }}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- View Info Modal for each order -->
                                    <div class="modal fade" id="orderInfo{{ $order->id }}" tabindex="-1" aria-labelledby="orderInfoLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orderInfoLabel">Order Information</h5>
                                                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Include the desired information here -->
                                                        <p>Order ID: {{ $order->id }}</p>
                                                        <p>Address: {{ $order->address }}</p>
                                                        <p>Contact: {{ $order->contact }}</p>
                                                        <p>Message: {{ $order->message }}</p>
                                                        <p>Delivery: {{ $order->delivery }}</p>
                                                        <p>Date ordered: {{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y') }}</p>
                                                        <p>Time ordered: {{ \Carbon\Carbon::parse($order->created_at)->format(' H:i:s') }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                    <div class="card-body">
                                        @php
                                            $totalAmount = 0;
                                        @endphp
                                        @foreach ($order->orderItems as $orderItem)
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    @if ($orderItem->image_path)
                                                        <img src="{{ asset('storage/' . $orderItem->image_path) }}" alt="Product Image" style="max-width: 100px">
                                                    @else
                                                        No Image
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <p>{{ $orderItem->product_name }}</p>
                                                    <br><br>
                                                    <p>₱{{ $orderItem->price }} &nbsp;&nbsp;&nbsp;&nbsp; x{{ $orderItem->quantity }}</p>
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
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    You have no {{ strtolower(str_replace('Orders', '', $status)) }} orders.
                </div>
            @endif
        </div>
    @endforeach
</div>

        </div>
    </div>
    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Font Awesome JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    console.log('SweetAlert is loaded and listening.');

    const cancelButtons = document.querySelectorAll('.cancel-order');

    cancelButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const form = this.parentElement;

            console.log('Cancel button clicked.');
            
            Swal.fire({
                title: 'Do you want to cancel this order?',
                showDenyButton: true,
                confirmButtonText: 'Yes, cancel it',
                denyButtonText: `No, keep it`,
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire('Your order is canceled!', '', 'success')
                } else if (result.isDenied) {
                    Swal.fire('Your order is not canceled', '', 'info');
                }
            });


        });
    });
});

</script>

</x-app-layout>
<footer class="text-white text-center text-lg-start bg-dark">
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row mt-4">
        <!--Grid column-->
        <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">About company</h5>

          <p>
          <b>Dulay Party Needs</b> is your all-in-one destination for celebration essentials. From delectable cakes to vibrant balloons, we've got you covered. Explore curated packages for special occasions like Valentine's Day, ensuring your moments are effortlessly extraordinary. 
          </p>

          <p>
          Celebrate with quality products and thoughtful curation at Dulay Party Needs, where every detail is designed to make your festivities memorable.
          </p>

          <!-- <div class="mt-4">
            
            <a type="button" class="btn btn-floating btn-light btn-lg"><i class="fab fa-facebook-f"></i></a>
            
            <a type="button" class="btn btn-floating btn-light btn-lg"><i class="fab fa-dribbble"></i></a>
            
            <a type="button" class="btn btn-floating btn-light btn-lg"><i class="fab fa-twitter"></i></a>
            
            <a type="button" class="btn btn-floating btn-light btn-lg"><i class="fab fa-google-plus-g"></i></a>
            
          </div> -->
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <ul class="fa-ul" style="margin-left: 1.65em;">
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-home"></i></span><span class="ms-2">Municipal St, San Nicolas, Pangasinan</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-envelope"></i></span><span class="ms-2">dulaypartyneeds@gmail.com</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-phone"></i></span><span class="ms-2">0920 741 1367</span>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4">Physical Store Opening hours</h5>

          <table class="table text-center text-white">
            <tbody class="fw-normal">
              <tr>
                <td>Mon - Thu:</td>
                <td>8am - 5pm</td>
              </tr>
              <tr>
                <td>Fri - Sat:</td>
                <td>8am - 5pm</td>
              </tr>
              <tr>
                <td>Sunday:</td>
                <td>Close</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2023 Copyright:
      <a class="text-white" href="#">Buca Company</a>
    </div>
    <!-- Copyright -->
  </footer>
</body>
</html>
