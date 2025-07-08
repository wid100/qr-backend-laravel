@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Basic Form</h6>

                        <form class="forms-sample" action="{{ route('admin.card-order.update', $order->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $order->name }}" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ $order->email }}" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $order->phone }}" placeholder="Phone">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" class="form-control" id="country" name="country"
                                            value="{{ $order->country }}" placeholder="Country">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="{{ $order->city }}" placeholder="City">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $order->address }}" placeholder="Address">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="zip" class="form-label">zip</label>
                                        <input type="text" class="form-control" id="zip" name="zip"
                                            value="{{ $order->zip }}" placeholder="Zip Code">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <input type="text" class="form-control" id="payment_method" name="payment_method"
                                            value="{{ $order->payment_method }}" placeholder="Payment Method">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="text" class="form-control" id="quantity" name="quantity"
                                            value="{{ $order->quantity }}" placeholder="Quantity">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="total_price" class="form-label">Total Price</label>
                                        <input type="text" class="form-control" id="total_price" name="total_price"
                                            value="{{ $order->total_price }}" placeholder="Total Price">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="order_date" class="form-label">Order Date</label>
                                        <input type="date" class="form-control" id="order_date" name="order_date"
                                            value="{{ $order->order_date }}" placeholder="Order Date">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="order_number" class="form-label">Order Number</label>
                                        <input type="text" class="form-control" id="order_number" name="order_number"
                                            value="{{ $order->order_number }}" placeholder="Order Number">
                                    </div>
                                </div>






                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="completed"
                                                {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled"
                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $order->smartCard->font_image) }}" alt=""
                                            width="100">

                                    </div>
                                </div>
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
