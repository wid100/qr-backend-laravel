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
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Instagram Form</h6>

                        <form class="forms-sample" action="{{ route('admin.instagram.update', $instagram->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $instagram->instagram_name }}" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="instagram_username" class="form-label">Instagram Name</label>
                                        <input type="text" class="form-control" id="instagram_username" name="instagram_username"
                                            value="{{ $instagram->instagram_username }}" placeholder="Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox"
                                            class="form-check-input"{{ $instagram->status == 1 ? 'checked' : '' }}
                                            id="statis" name="status">
                                        <label class="form-check-label" for="statis">
                                            Active
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
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
