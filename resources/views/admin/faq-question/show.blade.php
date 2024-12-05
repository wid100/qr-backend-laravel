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
                        <h6 class="card-title">FAQ</h6>
                        <div class="mt-3">
                            <h4>{{ $question->section->title ?? '' }}</h4>
                            <h5>{{ $question->question ?? '' }}</h5>
                            <p>{{ $question->answer ?? '' }}</p>
                        </div>

                        <div class="gap-1">
                            <a class=" btn btn-primary btn-sm" href="{{ route('admin.faq-question.index') }}">Back</a>

                            <a href="{{ route('admin.faq-question.edit', $question->id) }}" class="btn btn-primary btn-icon  btn-sm"><i data-feather="edit"></i></a>

                            @if (Auth::user()->role_id == 1)
                                <form id="delete_form_{{ $question->id }}"
                                    action="{{ route('admin.faq-question.destroy', $question->id) }}"
                                    method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-icon delete-button btn-sm"
                                    onclick="deleteId({{ $question->id }})">
                                    <i data-feather="trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
