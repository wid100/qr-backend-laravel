@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Users</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Users Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Join date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                                @if ($user->image)
                                                    <img src="{{ asset($user->image) }}" alt="Image not found">
                                                @else
                                                    <i data-feather="user"></i>
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->country }}</td>
                                            <td>{{ $user->city }}</td>
                                            <td>{{ $user->created_at }}</td>
                                            <td>
                                                @if ($user->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($user->status === 0)
                                                    <span class="badge bg-danger">Block User</span>
                                                @else
                                                    <span class="badge bg-danger">No Status</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-danger btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                <button type="button" class="btn btn-primary btn-icon">
                                                    <i data-feather="check-square"></i>
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
