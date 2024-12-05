@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Template category</a></li>
                <li class="breadcrumb-item active" aria-current="page">All template Category</li>
            </ol>
            <a href="{{ route('admin.tempcategory.create') }}" class="btn btn-primary active" role="button"
                aria-pressed="true">Create</a>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Template Category</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Create Date</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tempcategory as $key => $item)
                                        <tr class="insta-template-tr">
                                            <td>{{ $key + 1 }}</td>
                                            <td width="100">{!! $item->name !!}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                            {{-- <td>
                                                @if ($item->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Deactivate</span>
                                                @endif
                                            </td> --}}
                                            <td>
                                                <a href="{{ route('admin.tempcategory.edit', $item->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $item->id }}"
                                                        action="{{ route('admin.tempcategory.destroy', $item->id) }}"
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
