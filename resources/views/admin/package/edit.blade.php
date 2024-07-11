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

                        <form class="forms-sample" action="{{ route('admin.package.update', $package->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $package->name }}" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <select class="js-example-basic-single form-select" name="country" id="country"
                                            data-width="100%">
                                            @foreach ($countres as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ $package->country_id == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="qr_qt" class="form-label">QR Quentity</label>
                                        <input type="text" class="form-control" name="qr_qt"
                                            id="qr_qt"value="{{ $package->qr_qt }}" placeholder="QR Quentity">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="scan_limit" class="form-label">Scan Limit</label>
                                        <input type="text" class="form-control" name="scan_limit" id="scan_limit"
                                            placeholder="Scan Limit"value="{{ $package->scan_limit }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="website_qr_limit" class="form-label">Website QR Limit</label>
                                        <input type="text" class="form-control" name="website_qr_limit"
                                            id="website_qr_limit"
                                            placeholder="Website QR Limit"value="{{ $package->website_qr_limit }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ecommerch_limit" class="form-label">Ecommerch Limit</label>
                                        <input type="text" class="form-control" name="ecommerch_limit"
                                            id="ecommerch_limit"
                                            placeholder="Ecommerch Limit"value="{{ $package->ecommerch_limit }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="card" class="form-label">Card</label>
                                        <input type="text" class="form-control" name="card" id="card"
                                            placeholder="Card"value="{{ $package->card }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control"value="{{ $package->price }}"
                                            name="price" id="price" placeholder="Price">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Description</label>
                                        <textarea class="form-control" name="description" id="tinymceExample" rows="5">{{ $package->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox"
                                            class="form-check-input"{{ $package->status == 1 ? 'checked' : '' }}
                                            id="statis" name="status">
                                        <label class="form-check-label" for="statis">
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
