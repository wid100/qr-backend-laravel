@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb d-flex justify-content-between">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Messages</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Messages</li>
            </ol>
            <a href="{{ route('admin.faq-question.create') }}" class="btn btn-primary">New Section</a>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">FAQ Table</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Section</th>
                                        <th>Question</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($fAQQuestion)
                                    @foreach ($fAQQuestion as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td> {{  $item->section->title ?? '' }}</td>
                                            <td>
                                                {{  $item->question ?? '' }}
                                            </td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                @if ($item->status == 0)
                                                    <span class="badge bg-success text-dark">Active</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.faq-question.show', $item->id) }}" class="btn btn-info btn-icon  btn-sm"><i data-feather="eye"></i></a>
                                                <a href="{{ route('admin.faq-question.edit', $item->id) }}" class="btn btn-primary btn-icon  btn-sm"><i data-feather="edit"></i></a>

                                                @if (Auth::user()->role_id == 1)
                                                    <form id="delete_form_{{ $item->id }}"
                                                        action="{{ route('admin.faq-question.destroy', $item->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-icon delete-button btn-sm"
                                                            onclick="deleteId({{ $item->id }})">
                                                            <i data-feather="trash"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                        </tr>
                                    @endforeach
                                    @endisset

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>SL</th>
                                        <th>Section</th>
                                        <th>Question</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
