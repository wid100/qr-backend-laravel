@extends('master.master')

@section('content')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Basic Elements</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Basic Form</h6>
                        <form class="forms-sample" action="{{ route('admin.instacategory.update', $category->id) }}"
                            method="POST">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $category->name }}" placeholder="Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox"
                                            class="form-check-input"{{ $category->status === 1 ? 'checked' : '' }}
                                            id="statis" name="status">
                                        <label class="form-check-label" for="statis">
                                            Active
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
