@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb d-flex align-center justify-content-between">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Card orders</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Physical smart card orders</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>User account</th>
                                        <th>Design</th>
                                        <th>Font image</th>
                                        <th>Digital card</th>
                                        <th>Order no</th>
                                        <th>Billing name</th>
                                        <th>Billing email</th>
                                        <th>Phone</th>
                                        <th>Payment</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ optional($order->user)->name ?? 'N/A' }}
                                                @if (optional($order->user)->email)
                                                    <br><small>{{ $order->user->email }}</small>
                                                @endif
                                            </td>
                                            <td>{{ optional($order->smartCard)->name ?? 'N/A' }}</td>
                                            <td>
                                                @if ($order->smartCard && $order->smartCard->font_image)
                                                    <img src="{{ asset('storage/' . $order->smartCard->font_image) }}"
                                                        width="100" alt="">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->qrgen)
                                                    <a href="https://smartcardgenerator.net/{{ $order->qrgen->slug }}"
                                                        target="_blank" rel="noopener">
                                                        {{ $order->qrgen->cardname ?? $order->qrgen->slug }}
                                                    </a>
                                                    <br><small class="text-muted">{{ $order->qrgen->slug }}</small>
                                                @else
                                                    {{ $order->qrgen_id ?? 'N/A' }}
                                                @endif
                                            </td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->name ?? '—' }}</td>
                                            <td>{{ $order->email ?? '—' }}</td>
                                            <td>{{ $order->phone ?? '—' }}</td>
                                            <td>{{ $order->payment_method ?? '—' }}</td>
                                            <td>{{ number_format($order->total_price, 2) }}
                                                {{ $order->currency ?? 'BDT' }}</td>
                                            <td>
                                                @php
                                                    $st = $order->status;
                                                    $badge =
                                                        $st === 'cancelled'
                                                            ? 'danger'
                                                            : ($st === 'paid' || $st === 'delivered' || $st === 'completed'
                                                                ? 'success'
                                                                : 'warning');
                                                @endphp
                                                <span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $st)) }}</span>
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
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center py-4">No orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
