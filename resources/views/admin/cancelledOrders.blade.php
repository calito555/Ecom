@extends('layout.admin')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Cancelled Orders</h4>

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
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach($cancelledOrders as $cancelledOrder)
                                        <tr>
                                            <td>
                                                {{$cancelledOrder->name}}
                                            </td>

                                            <td>{{$cancelledOrder->email}}</td>

                                            <td>
                                                <p class="text-reset">{{$cancelledOrder->address}}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-2">
                                                        <img src="/productFolder/{{$cancelledOrder->productImage}}" alt="" class="avatar-xxs rounded-circle">
                                                    </div>
                                                    <div class="flex-grow-1">{{$cancelledOrder->productName}}</div>
                                                </div>
                                            </td>
                                            <td>{{$cancelledOrder->productQuantity}}</td>
                                            <td>{{number_format($cancelledOrder->unitPrice)}}</td>
                                            <td>{{number_format($cancelledOrder->totalPrice)}}</td>
                                            <td>{{$cancelledOrder->paymentStatus}}</td>
                                            <td>{{$cancelledOrder->created_at->format('M d, Y: h:ia')}}</td>
                                            <td>
                                                <span class="badge bg-danger-subtle text-danger ">{{$cancelledOrder->deliveryStatus}}</span>
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