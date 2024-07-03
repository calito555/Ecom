@extends('layout.app')

@section('content')

<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>My Account</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">My Account</li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>

<div class="main_content">

    <!-- START SECTION SHOP -->
    <div class="section">
        <div class="container">
            <div class="row">
                @include('account.account_nav')
                <div class="mt-4 col-lg-4 col-md-8">
                    <div class="tab-content dashboard_content">
                        <div class="card">

                            <div class="card-body" style="width: 100%;">
                                <div class="d-flex justify-content-center align-items-center gap-2" style="width: 100%; ">
                                    <img src="{{ $user->profile && $user->profile->profile_image ? asset('uploads/profile_image/' . $user->profile->profile_image) : asset('assets/images/user1.jpg') }}" style="width: 160px; height: 160px; border-radius: 50%;" alt="">

                                    <div class="d-flex flex-column gap-1">
                                        <p>{{ $user->name ?? 'No Name'}}</p>
                                        <p>{{ $user->email ?? '' }}</p>
                                        <p>{{ $user->phone ?? ''}}</p>
                                        <p>{{ $user->profile->display_name ?? ''}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 col-lg-8 col-md-8">
                    <div class="tab-content dashboard_content">

                        <div>
                            <div class="card">
                                <div class="card-header">
                                    <h3>Profile</h3>
                                </div>
                                <div class="card-body">

                                    <form method="POST" action="{{ route('saveProfile') }}" name="enq" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-3">
                                                <label>Profile Image<span class="required">*</span></label>
                                                <input class="form-control" name="profile_image" type="file">
                                                <span class="text-danger">@error('profile_image') {{$message}} @enderror</span>
                                            </div>

                                            <div class="form-group col-md-12 mb-3">
                                                <label>Display Name <span class="required"></span></label>
                                                <input class="form-control" name="display_name" type="text">
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h3>User Orders</h3>
                    <ul>
                        @forelse ($user->orders as $order)
                        <li>
                            Order ID: {{ $order->id }} <br>
                            Product Name: {{ $order->productName }} <br>
                            Quantity: {{ $order->productQuantity }} <br>
                            Total Price: {{ $order->totalPrice }} <br>
                            Status: {{ $order->status }}
                        </li>
                        @empty
                        <li>No orders found.</li>
                        @endforelse
                    </ul>
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

@endsection