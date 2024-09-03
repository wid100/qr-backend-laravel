@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Color</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Color</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Create Color</h6>
                        <form action="{{ route('admin.color.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Color Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="off" placeholder="Enter Color Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Color Code <span class="text-danger">*</span></label>
                                        <input  type="color" style="height: 40px" class="form-control" id="code" name="code"
                                            autocomplete="off" placeholder="Enter Code">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <label class="form-check-label" for="termsCheck">
                                            Active
                                        </label>
                                        <input type="checkbox" class="form-check-input" checked name="status"
                                            id="termsCheck">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Submit</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
