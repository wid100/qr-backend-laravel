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
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Basic Form</h6>
                        <form class="forms-sample" action="{{ route('admin.faq-question.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <select name="section" class="form-select @error('section') is-invalid @enderror" required >
                                            <option disabled selected>Open this select section</option>
                                            @isset($faq_section)
                                                @foreach ($faq_section as $item)
                                                    <option value="{{ $item->id }}" {{ old('section') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->title ?? '' }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>

                                        @error('section')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Question</label>
                                        <input class="form-control @error('question') is-invalid @enderror" type="text" name="question" value="{{ old('question') }}">
                                        @error('question')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="answer" class="form-control @error('answer') is-invalid @enderror" placeholder="Answer" id="floatingTextarea" style="height: 150px" spellcheck="false">{{ old('answer') }}</textarea>
                                        @error('answer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="ms-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="0" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                          Active
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="1">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                          Inactive
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
