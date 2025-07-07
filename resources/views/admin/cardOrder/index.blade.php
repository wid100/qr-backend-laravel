@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb d-flex align-center justify-content-between">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Color List Table</li>
            </ol>
            <a href="{{ route('admin.color.create') }}" class="btn btn-primary">Create
                Color </a>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Color List Table</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Smart Card</th>
                                        <th>Font Image</th>
                                        <th>Order No</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Payment Method</th>

                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>{{ $order->smartCard->name ?? 'N/A' }}</td>
                                            <td><img src="{{ asset('storage/' . $order->smartCard->font_image) }}"
                                                    width="100" alt=""></td>
                                            </td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->payment_method }}</td>
                                            <td>{{ number_format($order->total_price, 2) }} {{ $order->currency ?? 'USD' }}

                                            <td>
                                                <span
                                                    class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('admin.card-order.edit', $order->id) }}"
                                                        class="btn btn-primary btn-icon">
                                                        <i data-feather="edit"></i></a>
                                                    @if (Auth::user()->role_id == 1)
                                                        <form id="delete_form_{{ $order->id }}"
                                                            action="{{ route('admin.card-order.destroy', $order->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $order->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
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
