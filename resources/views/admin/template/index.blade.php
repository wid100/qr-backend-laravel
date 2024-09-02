@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Template</a></li>
                <li class="breadcrumb-item active" aria-current="page">All template</li>
            </ol>
            <a href="{{ route('admin.template.create') }}" class="btn btn-primary active" role="button"
                aria-pressed="true">Create</a>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Template</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>Primary Color</th>
                                        <th>Text Color</th>
                                        <th>Create Date</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($template as $key => $item)
                                        <tr class="insta-template-tr">
                                            <td>{{ $key + 1 }}</td>
                                            <td><img class=" rounded shadow img-fluid" src="{{ asset($item->image) }}" alt="image" /></td>
                                            <td>
                                                <p class="text-muted" style="font-size: 10px">UUID: <span >{{ $item->uuid }}</span></p>
                                                {{ $item->templateCategory->name }}
                                            </td>
                                            <td width="100">{!! $item->name !!}</td>
                                            <td class="rounded" style="background-color:{{ $item->primary_color ?? 'Not available' }}">{{ $item->primary_color ?? 'Not available' }}</td>
                                            <td class="rounded" style="color:{{ $item->text_color ?? 'Not available' }}">{{ $item->text_color ?? 'Not available' }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                            {{-- <td>
                                                @if ($item->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Deactivate</span>
                                                @endif
                                            </td> --}}
                                            <td>
                                                <a href="{{ route('admin.template.edit', $item->id) }}"
                                                    class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i></a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $item->id }}"
                                                        action="{{ route('admin.template.destroy', $item->id) }}"
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
