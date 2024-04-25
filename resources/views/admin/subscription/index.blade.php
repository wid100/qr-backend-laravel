@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Subscription</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Subscription</li>
            </ol>

        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Subscription Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Name</th>
                                        <th>Package</th>
                                        <th>Payment</th>
                                        <th>Amount</th>
                                        <th>Transaction ID</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $key => $subscription)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $subscription->user->name }}</td>
                                            <td>{{ $subscription->package->name }}</td>
                                            <td>{{ $subscription->payment->payment_method }}</td>
                                            <td>{{ $subscription->payment->amount }}</td>
                                            <td>{{ $subscription->payment->transaction_id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($subscription->end_date)->format('d/m/Y') }}</td>

                                            <td> <span class="badge bg-success">{{ $subscription->status }}</span></td>

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
