@extends('layout.app')

@section('content')

<div class="main_content">

    <!-- START LOGIN SECTION -->
    <div class="login_register_wrap section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                <h3>Pay for Product - &#8358;{{ $grandTotal }}</h3>
                    <form method="POST" action="{{ route('pay', $grandTotal) }}" id="paymentForm">
                        {{ csrf_field() }}

                        <input name="name" class="form-control" placeholder="Name" />
                        <input name="email" class="form-control" type="email" placeholder="Your Email" />
                        <input name="phone" class="form-control" type="tel" placeholder="Phone number" />
                        <input name="address" class="form-control" type="text" placeholder="Address" />

                        <input type="submit" value="Pay" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END LOGIN SECTION -->

</div>


@endsection