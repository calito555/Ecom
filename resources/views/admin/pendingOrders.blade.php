@extends('layout.admin')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Pending Orders</h4>

                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-centered align-middle table-nowrap mb-0" id="customerTable">
                                    <thead class="text-muted table-light">
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                            <th>Payment Method</th>
                                            <th>Order Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach($pendingOrders as $pendingOrder)
                                        <tr>
                                            <td>
                                                {{$pendingOrder->name}}
                                            </td>

                                            <td>{{$pendingOrder->email}}</td>

                                            <td>
                                                <p class="text-reset">{{$pendingOrder->address}}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-2">
                                                        <img src="/productFolder/{{$pendingOrder->productImage}}" alt="" class="avatar-xxs rounded-circle">
                                                    </div>
                                                    <div class="flex-grow-1">{{$pendingOrder->productName}}</div>
                                                </div>
                                            </td>
                                            <td>{{$pendingOrder->productQuantity}}</td>
                                            <td>{{number_format($pendingOrder->unitPrice)}}</td>
                                            <td>{{number_format($pendingOrder->totalPrice)}}</td>
                                            <td>{{$pendingOrder->paymentStatus}}</td>
                                            <td>{{$pendingOrder->created_at->format('M d, Y: h:ia')}}</td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-warning ">{{$pendingOrder->deliveryStatus}}</span>
                                            </td>

                                            <td>
                                                <a href="{{ route('approveOrder', $pendingOrder->id) }}" onclick="return confirm('Are you sure you want to Approve this order')" class="btn btn-success text-bg-light">Approve</a>
                                                <a href="{{ route('disapproveOrder', $pendingOrder->id) }}" onclick="return confirm('Are you sure you want to Disapprove this order')" class="btn btn-danger text-bg-light">Dissaprove</a>
                                            </td>

                                        </tr>
                                        @endforeach


                                        <!-- end tr -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Toner.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by Themesbrand
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

@endsection