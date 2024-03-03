@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Packages</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Packages</li>
            </ol>
            <a href="{{ route('admin.package.create') }}" class="btn btn-primary active" role="button"
                aria-pressed="true">Create Package</a>

        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Packages Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Country</th>
                                        {{-- <th>Plan Type</th> --}}
                                        <th>QR Limit</th>
                                        <th>Scan Limit</th>
                                        <th>Website QR</th>
                                        <th>Eco Limit</th>
                                        <th>Card</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $key => $package)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $package->name }}</td>
                                            <td>{{ $package->price }}</td>
                                            <td>{{ $package->country->name }}</td>
                                            {{-- <td>{{ $package->plan_type }}</td> --}}
                                            <td>{{ $package->qr_qt }}</td>
                                            <td>{{ $package->scan_limit }}</td>
                                            <td>{{ $package->website_qr_limit }}</td>
                                            <td>{{ $package->ecommerch_limit }}</td>
                                            <td>{{ $package->card }}</td>
                                            <td>
                                                @if ($package->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($package->status === 0)
                                                    <span class="badge bg-danger">Draft Package</span>
                                                @else
                                                    <span class="badge bg-danger">No Status</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.package.edit', $package->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $package->id }}"
                                                        action="{{ route('admin.package.destroy', $package->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $package->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
