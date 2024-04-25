@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Payment</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Payment</li>
            </ol>

        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Payment Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Package</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Transaction ID</th>
                                        <th>Create Date</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payment as $key => $payment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $payment->user->name }}</td>
                                            <td>{{ $payment->package->name }}</td>
                                            <td>{{ $payment->amount }}</td>
                                            <td>{{ $payment->payment_method }}</td>
                                            <td>{{ $payment->transaction_id }}</td>
                                            <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                            <td> <span class="badge bg-success">Success</span></td>

                                            {{-- <td>
                                                <a href="{{ route('admin.payment.edit', $payment->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $payment->id }}"
                                                        action="{{ route('admin.payment.destroy', $payment->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $payment->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td> --}}

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
