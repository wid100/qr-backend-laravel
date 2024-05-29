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
                        <form class="forms-sample" action="{{ route('admin.instatemplate.update', $template->id) }}"
                            method="POST">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Single select box using select 2</label>
                                        <select class="js-example-basic-single form-select" name="insta_category"
                                            data-width="100%">
                                            @foreach ($insta_category as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $template->insta_category ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="template" class="form-label">Template</label>
                                        <textarea name="template" class="form-control" id="template" cols="30" rows="10">{{ $template->template }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-check mb-3">
                                        <input type="checkbox"
                                            class="form-check-input"{{ $template->status === 1 ? 'checked' : '' }}
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
