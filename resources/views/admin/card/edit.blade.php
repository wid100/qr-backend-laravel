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

                        <h6 class="card-title">Basic Form</h6>

                        <form class="forms-sample" action="{{ route('admin.card.update', $card->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        <div class="mt-2">
                                            <img id="previewImage"
                                                src="{{ $card->image ? asset($card->image) : asset('assets/images/placeholder.png') }}"
                                                alt="Profile Picture" class="img-thumbnail"
                                                style="width: 100px; height: 100px;">
                                        </div>
                                        @error('image')
                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                        @enderror
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

    <script>
        const imageInput = document.getElementById('image');
        const previewImage = document.getElementById('previewImage');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                previewImage.src =
                    "{{ $card->image ? asset($card->image) : asset('assets/images/placeholder.png') }}";
            }
        });
    </script>
@endsection
