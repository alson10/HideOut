<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('assets/images/dulaypartyneeds.png') }}" type="">
    <!-- Include Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
<x-app-layout>
    <x-slot name="header" class="container">
        <div class="d-flex flex-row justify-content-between align-items-center">
            
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Available Products') }}
        </h2>
        
        <form action="{{ route('showProducts.index') }}" method="GET" class="d-flex my-2 my-lg-0">
                <input class="form-control me-sm-2" type="text"name="search" placeholder="Search"value="{{ Request::input('search') }}">
                <!-- <input type="text" name="search" placeholder="Search..." class="mr-2" value="{{ Request::input('search') }}"> -->
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </x-slot>
    
    <div class="container mt-4">
    <ul class="nav nav-pills nav-fill `justify-content-center`">
            @foreach (['allProducts', 'BrandyProducts', 'GinProducts','RumProducts', 'TequilaProducts', 'VodkaProducts', 'WhiskeyProducts', 'PackageProducts'] as $key => $category)
                <li class="nav-item">
                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#{{ $category }}">{{ ucfirst(str_replace('Products', '', $category)) }}</a>
                </li>
            @endforeach
        </ul>
    <div class="tab-content">
    <div class="tab-pane active" id="allProducts">
    @if ($products && count($products) > 0)
    <div class="row">
        @foreach ($products as $product)
            @if ($product->quantity > 0)
         <div class="col-md-2 mb-2 mt-5">
            <div class="card" style="width: 100%; height: 100%;">
                <div class="image-container">
                    <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top img-fluid" style="object-fit: cover; height: 150px;" alt="{{ $product->name }}">
                </div>
                <div class="card-body">
                    <h2 class="card-title"><b>{{ $product->name }}</b></h2>
                    <p class="card-text" style="color:red">₱{{ $product->price }}</p>
                    <div class="input-group mb-3">
                        <!-- Button trigger modal -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $product->id }}">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div> 

            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal-{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel-{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fs-5" id="exampleModalLabel-{{ $product->id }}">{{ $product->name }}</h5>
                    <p>{{ $product->description }}</p>
                </div>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 350px; max-width: 100%;">
            </div>
                <div class="modal-footer d-flex justify-content-between">
                        <form action="{{ route('cart.addToCart', $product->id) }}" method="POST" class="w-100 d-flex align-items-center">
                            @csrf
                            <div class="input-group me-3 ms-2" style="max-width: 320px;">
                            <span class="input-group-text">Quantity</span>
                                <!-- <label for="quantity" class="me-2" style="min-width: 70px;">Quantity:</label>s -->
                                
                                <input type="number" name="quantity" class="form-control"  style="max-width: 150px;" value="1" min="1">
                            </div>
                            
                            <button class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        </div>
        @endif
        </div>
    </div>

<div class="tab-content">
    @foreach (['BrandyProducts', 'GinProducts','RumProducts', 'TequilaProducts', 'VodkaProducts', 'WhiskeyProducts', 'PackageProducts'] as $category)
    <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $category }}">
    @if ($products && count($products) > 0)
    <div class="row">
        @foreach ($products as $product)
        @if ($product->quantity > 0)
            @if ($product->category === str_replace('Products', '', $category))
            <div class="col-md-2 mb-2 mt-5">
                <div class="card" style="width: 100%; height: 100%;">
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="card-img-top img-fluid" style="object-fit: cover; height: 150px;"  alt="{{ $product->name }}">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title"><b>{{ $product->name }}</b></h2>
                        <p class="card-text" style="color:red">₱{{ $product->price }}</p>
                        <div class="input-group mb-3">
                            <!-- Button trigger modal -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal-{{ $product->id }}">
                                <i class="fas fa-shopping-cart"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="productModal-{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel-{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                            <h5 class="modal-title fs-5" id="productModalLabel-{{ $product->id }}">{{ $product->name }}</h5>
                            <p>{{ $product->description }}</p>
                            </div>
                            
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>  
                        <div class="modal-body d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 350px; max-width: 100%;">
                        </div>


                        <div class="modal-footer d-flex justify-content-between">
                            
                            <form action="{{ route('cart.addToCart', $product->id) }}" method="POST">
                                @csrf
                                <div class="input-group mb-2">
                                        <label for="quantity" class="me-2">Quantity:</label>
                                        <input type="number" name="quantity" class="form-control me-5 addtocart" value="1" min="1">
                                        <button class="btn btn-primary ">Add to Cart</button>
                                    </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @endforeach
        </div>
        @endif
        </div>
        @endforeach 
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Listening for the button click to trigger SweetAlert
        document.addEventListener('DOMContentLoaded', function () {
            console.log('SweetAlert is loaded and listening.');

            const addtocartButtons = document.querySelectorAll('.addtocart');

            addtocartButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    console.log('addtocart button clicked.');

                    Swal.fire(
                        'Good job!',
                        'You clicked the button!',
                        'success'
                    );
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
