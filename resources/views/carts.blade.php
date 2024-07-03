@extends('layout.app')

@section('content')


@if($cartCount > 0)
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Shopping Cart</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">Shopping Cart</li>
                </ol>
            </div>

            <div class="row justify-content-center mt-2">
                <div class="col-md-6">
                    <div class="d-flex align-items-center ">
                        <h5 class="mb-0 flex-grow-1 fw-medium">There are <span class="fw-bold">{{ $cartCount }}</span> products in your cart</h5>
                    </div>
                </div>

            </div>
        </div>

    </div><!-- END CONTAINER-->
</div>


<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive shop_cart_table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">&nbsp;</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-subtotal">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>


                            <!-- Asigning of a variable called grandTotal and setting it = 0; -->

                            @php
                            $grandTotal = 0;


                            @endphp
                                
                                @foreach($carts as $cart)
                                <tr>
                                    <td class="product-thumbnail"><a href="#"><img src="/productFolder/{{ $cart->productImage}}" alt="product1"></a></td>
                                    <td class="product-name" data-title="Product"><a href="#">{{ $cart->productName }}</a></td>
                                    <td class="product-price" data-title="Price">${{ number_format($cart->unitPrice)}}</td>
                                    <td class="product-quantity" data-title="Quantity">
                                        <div class="quantity">
                                            <input type="text" name="quantity" value="{{ $cart->productQuantity}}" readonly title="Qty" class="qty" size="4">

                                        </div>
                                    </td>
                                    <td class="product-subtotal" data-title="Total">${{ number_format($cart->totalPrice)}}</td>
                                    <td class="product-remove" data-title="Remove"><a onclick="return confirm('Are you sure you want to delete this Cart')" href="{{ route('deleteCart', $cart->id) }}"><i class="ti-close"></i></a></td>
                                </tr>

                                <!-- Loop or formular for our grandTotal OR an itilation -->
                                @php 
                                $grandTotal += $cart->totalPrice  

                                @endphp 

                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="medium_divider"></div>
                    <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                    <div class="medium_divider"></div>
                </div>
            </div>
            <div class="row justify-content-center">

                <div class="col-md-6">
                    <div class="border p-3 p-md-4">
                        <div class="heading_s1 mb-3">
                            <h6>Cart Totals</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>

                                    <tr>
                                        <td class="cart_total_label">Total</td>
                                        <td class="cart_total_amount"><strong>${{ number_format($grandTotal) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('payOnDelivery') }}" class="btn btn-fill-out">Pay on Delivery</a>
                        <a href="{{ route('payment', $grandTotal) }}" class="btn btn-fill-out">Pay Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION SHOP -->

    <!-- START SECTION SUBSCRIBE NEWSLETTER -->
    <div class="section bg_default small_pt small_pb">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="heading_s1 mb-md-0 heading_light">
                        <h3>Subscribe Our Newsletter</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="newsletter_form">
                        <form>
                            <input type="text" required="" class="form-control rounded-0" placeholder="Enter Email Address">
                            <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- START SECTION SUBSCRIBE NEWSLETTER -->

</div>
@else
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>No item in the cart</h1>
                </div>
            </div>
        </div>

    </div><!-- END CONTAINER-->
</div>

@endif



@endsection