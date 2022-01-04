@extends('layouts.app')

@section('title', 'Order Details')

@section('styles')
    <link href="{{  url('public/assets') }}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="{{ url('public/assets') }}/vendor/toastr/css/toastr.min.css">

    <style>
        tbody tr{
            color: black !important;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Order Details</h4>
                    <div class="card-toolbar">
                    </div>
                </div>

                <div class="card-body">
                    <div>
                        <h4>Product details</h4>
                            @foreach($orderProduct as $op)
                                <h6>Product Name: </h6>
                                <p class="font-weight-bold text-black-50">{{ $op->product->name }}</p>
                                <h6>Qty: </h6>
                                <p class="font-weight-bold text-black-50">{{ $op->quantity }}</p>
                                <h6>Attributes: </h6>
                                <p class="font-weight-bold text-black-50">{{ $op->attr }}</p>
                                <h6>Total: </h6>
                                <p class="font-weight-bold text-black-50">{{ $op->total }}</p>
                            @endforeach
                        <hr>

                        <h4>Customer Details</h4>
                        <h6>Email:</h6>
                            <p class="font-weight-bold text-black-50">{{ $customer->email }}</p>
                        <h6>Name:</h6>
                            <p class="font-weight-bold text-black-50">{{ $customer->fname.' '.$customer->lname }}</p>
                        <h6>Address:</h6>
                            <p class="font-weight-bold text-black-50">{{ $customer->address }}</p>
                        <h6>City:</h6>
                            <p class="font-weight-bold text-black-50">{{ $customer->city }}</p>
                        <h6>Country:</h6>
                            <p class="font-weight-bold text-black-50">{{ $customer->country }}</p>
                        <h6>Phone:</h6>
                            <p class="font-weight-bold text-black-50">{{ $customer->phone }}</p>

                        <hr>

                        <h4>Order Summary</h4>
                        <h6>Sub Total:</h6>
                            <p class="font-weight-bold text-black-50">{{ $order->sub_total }}</p>
                        <h6>Discount:</h6>
                            <p class="font-weight-bold text-black-50">{{ $order->discount }}</p>
                        <h6>Discount Code:</h6>
                            <p class="font-weight-bold text-black-50">{{ $order->discount_code }}</p>
                        <h6>Shipping:</h6>
                            <p class="font-weight-bold text-black-50">{{ $order->shipping }}</p>
                        <h6>Total:</h6>
                            <p class="font-weight-bold text-black-50">{{ $order->total }}</p>
                        <h6>Note:</h6>
                            <p class="font-weight-bold text-black-50">{{ $order->note }}</p>
                        <h6>Status:</h6>
                            <p class="font-weight-bold text-black-50">{{ $order->status }}</p>

                        <hr>
                        <h4>Change order status</h4>
                        <form action="{{ route('orders.status') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->id }}">
                            <select name="order_status" class="form-control form-control-lg" required>
                                <option value="">Select status</option>
                                <option value="PENDING">Pending</option>
                                <option value="IN-PROCESS">In Process</option>
                                <option value="COMPLETED">Completed</option>
                                <option value="DELIVERED">Delivered</option>
                                <option value="CANCELLED">Cancelled</option>
                            </select>
                            <input type="submit" value="Submit" class="btn btn-primary" style="margin-top: 20px">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
