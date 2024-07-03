@extends('layout.app')

@section('content')


@if($productCount > 0)
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>{{ $catName }}</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">{{ $catName }}</li>
                </ol>
            </div>

            <div class="row justify-content-center mt-2">
                <div class="col-md-6">
                    <div class="d-flex align-items-center ">
                        
                    </div>
                </div>

            </div>
        </div>

    </div><!-- END CONTAINER-->
</div>


<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">

    <div class="section small_pt pb_70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="heading_s1 text-center">
                        <h2>All Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="arrival" role="tabpanel" aria-labelledby="arrival-tab">
                            <div class="row shop_container">

                            <!-- VIEWING OUR PRODUCTS INFORMATIONS IN OUR HOME PAGE -->

                                @foreach($productCategories as $prd)
                                <div class="col-lg-3 col-md-4 col-6">
                                    <div class="product">
                                        <div class="product_img">
                                            <a href="shop-product-detail.html">
                                                <img src="/productFolder/{{ $prd->productImage}}" style="width:100%; height:230px; object-fit:cover; object-position: top;" alt="product_img1">
                                            </a>

                                        </div>
                                        <div class="product_info">
                                            <h6 class="product_title"><a href="{{ route('product_details', $prd->id) }}">{{ $prd->productName }}</a></h6>

                                            <div class="product_price">
                                                <!-- VIEWING OUR PRODUCT PRICE IN OUR HOME PAGE -->
                                                @if($prd->discountPrice != null)
                                                <span class="price">${{ number_format($prd->discountPrice) }}</span>
                                                <del>${{ number_format($prd->productPrice) }}</del>
                                                @else
                                                <span class="price">${{ number_format($prd->productPrice) }}</span>
                                                @endif
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                <p style="margin-bottom: 0px;">Quantity</p>
                                                <span >{{ number_format($prd->quantity) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
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
                    <h1>No Product Found</h1>
                </div>
            </div>
        </div>

    </div><!-- END CONTAINER-->
</div>

@endif



@endsection