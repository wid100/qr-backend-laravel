@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">instagrams</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Users</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">instagram Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>instagram Name</th>
                                        <th>instagram Link</th>
                                        <th>Image</th>

                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($instagrams as $instagram)
                                        <tr>
                                            <td>{{ $instagram->id }}</td>
                                            <td>{{ $instagram->instagram_name }}</td>
                                            <td>{{ $instagram->instagram_username }}</td>
                                            <td>
                                                @if ($instagram->image)
                                                    <img src="{{ asset($instagram->image) }}" alt="Image not found">
                                                @else
                                                    <i data-feather="instagram"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($instagram->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($instagram->status == 0)
                                                    <span class="badge bg-danger">Unverified</span>
                                                @else
                                                    <span class="badge bg-danger">No Status</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.instagram.edit', $instagram->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                {{-- @if (Auth::user() && Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $instagram->id }}"
                                                        action="{{ route('admin.instagram.destroy', $instagram->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $instagram->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif --}}
                                                 @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $instagram->id }}"
                                                        action="{{ route('admin.instagram.destroy', $instagram->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button"
                                                            onclick="deleteId({{ $instagram->id }})">
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
