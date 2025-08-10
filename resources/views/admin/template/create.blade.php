@extends('master.master')

@section('content')

    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Resume Categoru</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Basic Form</h6>
                        <form class="forms-sample" action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Select Template Category <sup class="text-danger">required</sup></label>
                                        <select name="cat_id" class="form-select  @error('cat_id') is-invalid @enderror" aria-label="Default select example" required>
                                            <option selected disabled>Template Category</option>
                                            @isset($template_category)
                                                @foreach ($template_category as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name ?? '' }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        @error('cat_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Title <sup class="text-success">optional</sup></label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Template Image</label>
                                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-6">
                                            <label for="color" class="form-label">Primary Color <sup class="text-danger">required</sup></label>
                                            <input name="primary_color" id="colorPicker" type="color" class="form-control input-lg p-0 w-50  @error('primary_color') is-invalid @enderror" value="#000000" style="height: 40pxy">
                                            @error('primary_color')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label for="color" class="form-label">Text Color <sup class="text-danger">required</sup></label>
                                            <input name="text_color" id="colorPicker" type="color" class="form-control input-lg p-0 w-50  @error('text_color') is-invalid @enderror" value="#000000" style="height: 40pxy">
                                            @error('text_color')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea name="code" class="form-control  @error('code') is-invalid @enderror" placeholder="Leave a comment here" id="floatingTextarea" style="height: 150px"></textarea>
                                        <label for="floatingTextarea">CSS <sup class="text-success">optional</sup></label>
                                        @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-md-12 d-flex justify-content-end">
                                    <a class="btn btn-dark me-2" href="{{ route('admin.template.index') }}">Cancel</a>
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
