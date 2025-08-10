@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Smart Card</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Cards</li>
            </ol>
            <a href="{{ route('admin.smart-card.create') }}" class="btn btn-primary"> Create
                Card</a>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Cards Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Card Name</th>
                                        <th>Front Image</th>
                                        <th>Back Image</th>
                                        <th>Price</th>
                                        <th>Discount Price</th>
                                        <th>Status</th>
                                        <th>Create Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cards as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name ?? '' }}</td>
                                            <td>
                                                <img src="{{ asset('storage/'.$item->font_image) }}" alt="" style="width: 150px; height:100px !important; ">
                                            </td>
                                            <td>
                                                <img src="{{ asset('storage/'.$item->back_image) }}" alt=""  style="width: 150px; height:100px !important; ">
                                            </td>
                                            <td>{{ $item->price ?? '' }}</td>
                                            <td>{{ $item->discount_price ?? '' }}</td>
                                            <td>
                                                @if ($item->status === 0)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Deactivate</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at ? $item->created_at->format('d M, Y') : '' }}</td>

                                            <td>
                                                <a href="{{ route('admin.smart-card.edit', $item->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $item->id }}"
                                                        action="{{ route('admin.smart-card.destroy', $item->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $item->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
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
