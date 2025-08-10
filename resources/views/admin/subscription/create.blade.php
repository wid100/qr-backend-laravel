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

                        <form class="forms-sample" action="{{ route('admin.subscription.store') }}" method="POST">
                            @csrf

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Users</label>
                                        <select class="js-example-basic-single form-select" name="user_id" id="user_id"
                                            data-width="100%">
                                            <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Select
                                                User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}/ {{ $user->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Packages</label>
                                        <select class="js-example-basic-single form-select" name="package_id"
                                            id="package_id" data-width="100%">
                                            <option value="" disabled {{ old('package_id') ? '' : 'selected' }}>Select
                                                Package</option>
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}"
                                                    {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                                    {{ $package->name }} / {{ $package->price }} {{ $package->currency }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('package_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="pay_amount" class="form-label">Pay Amount</label>
                                        <input type="text" class="form-control" id="pay_amount" name="pay_amount"
                                            value="{{ old('pay_amount') }}">
                                        @error('pay_amount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="transaction_id" class="form-label">Transaction ID</label>
                                        <input type="text" class="form-control" id="transaction_id" name="transaction_id"
                                            value="{{ old('transaction_id') }}">
                                        @error('transaction_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <input type="text" class="form-control" id="payment_method" name="payment_method"
                                            value="{{ old('payment_method') }}">
                                        @error('payment_method')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="statis" name="status"
                                            value="active">

                                        <label class="form-check-label" for="statis" name="status">
                                            Active
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
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
