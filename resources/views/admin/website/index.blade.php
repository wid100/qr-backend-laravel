@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">websites</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Users</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Website Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Website Name</th>
                                        <th>Website Link</th>
                                        <th>Image</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($websites as $website)
                                        <tr>
                                            <td>{{ $website->id }}</td>
                                            <td>{{ $website->website_name }}</td>
                                            <td>{{ $website->website_url }}</td>
                                            <td>
                                                @if ($website->image)
                                                    <img src="{{ asset($website->image) }}" alt="Image not found">
                                                @else
                                                    <i data-feather="website"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($website->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Deactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.website.edit', $website->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                {{-- @if (Auth::user() && Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $website->id }}"
                                                        action="{{ route('admin.website.destroy', $website->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $website->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif --}}
                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $website->id }}"
                                                        action="{{ route('admin.website.destroy', $website->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $website->id }})">
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
