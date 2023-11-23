<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
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
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>
    
    <div class="container mt-4">
        @if ($cartItems && count($cartItems) > 0)
            <div class="row justify-content-center"> <!-- Center the content -->
                <div class="col-md-10"> <!-- Adjust the column width -->
                    <div class="table-responsive"> <!-- Make the table responsive -->
                        <table class="table">
                            
                            <thead>
                                <tr>
                                    <!-- <th>Select</th> -->
                                    
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $totalPrice = 0; // Initialize the total price variable
                            @endphp
                                @foreach ($cartItems as $cartItem)
                                    <tr>
                                        <!-- <td>
                                            <input type="checkbox" name="selected_items[]" value="{{ $cartItem->id }}">
                                        </td> -->
                                        <td>
                                            @if ($cartItem->product)
                                                <img src="{{ asset($cartItem->product->image_path) }}" alt="{{ $cartItem->product->name }}" style="max-width: 80px; max-height: 80px;">
                                            @else
                                                Product not available (ID: {{ $cartItem->product_id }})
                                            @endif
                                        </td>
                                        <td><b>{{ optional($cartItem->product)->name }}</b></td>
                                        <td>
                                            @if ($cartItem->product)
                                                ₱{{ $cartItem->product->price }}
                                            @else
                                                Product not available
                                            @endif
                                        </td>
                                        <td>
                                            <!-- <input type="number" value="{{ $cartItem->quantity }}" min="1"> -->
                                            @if ($cartItem->quantity)
                                                {{ $cartItem->quantity }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($cartItem->product)
                                                ₱{{ $cartItem->quantity * $cartItem->product->price }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal_{{ $cartItem->id }}">
                                                Update
                                            </a>
                                            <div class="modal fade" id="updateModal_{{ $cartItem->id }}" tabindex="-1" aria-labelledby="updateModalLabel_{{ $cartItem->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateModalLabel_{{ $cartItem->id }}">Update Quantity</h5>
                                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('cart.update', $cartItem->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <label for="quantity">New Quantity:</label>
                                                                <input type="number" name="quantity" id="quantity" value="{{ $cartItem->quantity }}" min="1">
                                                                <button class="btn btn-primary">Update</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('cart.remove', $cartItem) }}" class="btn btn-danger btn-sm">Remove</a>
                                        </td>
                                        @php
                                            $productTotal = $cartItem->quantity * $cartItem->product->price;
                                            $totalPrice += $productTotal; // Calculate total price
                                        @endphp
                                    </tr>
                                    
                                @endforeach
                                <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <th>Total:</th>
                                        <th><h1> ₱{{ $totalPrice }}</h1></th>
                                        <td> 
                                            <div class="container">
                                                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                                                
                                                <button class="btn btn-warning btn-sm" id="checkoutButton" data-bs-toggle="modal" data-bs-target="#firstCheckoutModal">Checkout</button>

                                            </div>
                                            <!-- review order modal -->
                                            <div class="modal fade" id="firstCheckoutModal" tabindex="-1" aria-labelledby="firstCheckoutModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="firstCheckoutModalLabel">Checkout</h5>
                                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Image</th>
                                                                    <th>Product</th>
                                                                    <th>Price</th>
                                                                    <th>Quantity</th>
                                                                    <th>Total Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($cartItems as $cartItem)
                                                                    <tr>
                                                                        <td>
                                                                            @if ($cartItem->product)
                                                                                <img src="{{ asset('storage/' . $cartItem->product->image_path) }}" alt="{{ $cartItem->product->name }}" style="max-width: 80px; max-height: 80px;">
                                                                            @else
                                                                                Product not available (ID: {{ $cartItem->product_id }})
                                                                            @endif
                                                                        </td>
                                                                        <td><b>{{ optional($cartItem->product)->name }}</b></td>
                                                                        <td>
                                                                            @if ($cartItem->product)
                                                                                ₱{{ $cartItem->product->price }}
                                                                            @else
                                                                                Product not available
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($cartItem->quantity)
                                                                                {{ $cartItem->quantity }}
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if ($cartItem->product)
                                                                                ₱{{ $cartItem->quantity * $cartItem->product->price }}
                                                                            @else
                                                                                N/A
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <th>Total:</th>
                                                                    <th>₱{{ $totalPrice }}</th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <p>Please review your order before proceeding to checkout.</p>
                                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkoutModal">Continue to Checkout</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- main modal-->
                                            <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('orders.store') }}" method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="delivery" class="form-label">Choose Dining Option</label> <br>
                                                                    <select name="delivery" id="delivery">
                                                                        <option value="Dine-In">Dine-In</option>
                                                                        <option value="Take-Out">Take Out</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="contact" class="form-label">Contact no</label>
                                                                    <input type="number" class="form-control" id="contact" name="contact" placeholder="ex. 09123456789" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message" class="form-label">Message(optional)</label>
                                                                    <input type="text" class="form-control" id="message" name="message" placeholder="leave a message or instruction">
                                                                </div>
                                                                
                                                                <button class="btn btn-primary">Complete Checkout</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                Your shopping cart is empty.
            </div>
        @endif
    </div>

    <!-- Include Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Font Awesome JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    

  
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
