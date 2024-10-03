@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Resume</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Resume</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Resume Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th> Name</th>
                                        <th>Email</th>
                                        <th>Number</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($resumes)
                                    @foreach ($resumes as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                <img  class="border border-success" style="width: 38px; height:38px !important; object-fit: cover;border-radius: 50% !important; " src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?cs=srgb&dl=pexels-pixabay-220453.jpg&fm=jpg" alt="">

                                                {{ $item->user->name ?? 'Not Available' }}</td>
                                            <td>{{ $item->email ?? 'Not Available' }}</td>
                                            <td>{{ $item->phone  ?? 'Not Available' }}</td>
                                            <td>{{ $item->created_at  }}</td>
                                            <td>
                                                @if ($item->status == 0)
                                                    <span class="badge bg-success text-dark">Active</span>
                                                @else
                                                    <span class="badge bg-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.resume.show', $item->id) }}" class="btn btn-primary btn-icon  btn-sm"><i data-feather="eye"></i></a>
                                                <a href="{{ route('admin.resume.edit', $item->id) }}" class="btn btn-primary btn-icon  btn-sm"><i data-feather="edit"></i></a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $item->id }}"
                                                        action="{{ route('admin.resume.destroy', $item->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button btn-sm"
                                                            onclick="deleteId({{ $item->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endisset

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
