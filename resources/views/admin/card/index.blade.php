@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Cards</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Cards</li>
            </ol>
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
                                        <th>User Id</th>
                                        <th>Image</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Total Scan</th>
                                        <th>Join date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cards as $key => $card)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $card->user_id }}</td>
                                            <td>
                                                @if ($card->image)
                                                    <img src="{{ asset($card->image) }}" alt="Image not found">
                                                @else
                                                    <i data-feather="user"></i>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($card->welcome)
                                                    <img src="{{ asset($card->welcome) }}" alt="Image not found">
                                                @else
                                                    <i data-feather="user"></i>
                                                @endif
                                            </td>
                                            <td>{{ $card->cardname }}</td>
                                            <td>{{ $card->email1 }}</td>
                                            <td>{{ $card->mobile1 }}</td>
                                            <td>{{ $card->viewcount }}</td>
                                            <td>{{ $card->created_at }}</td>
                                            <td>
                                                @if ($card->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">No Status</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.card.edit', $card->id) }}"
                                                    class="btn btn-danger btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                <button type="button" class="btn btn-primary btn-icon">
                                                    <i data-feather="trash-2"></i>
                                                </button>
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
