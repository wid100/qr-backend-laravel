@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Cards</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Card</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Create Card</h6>

                        <form action="{{ route('admin.smart-card.update', $card->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Card Name<span
                                                class='text-danger'>*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="off" placeholder="Enter name" value="{{ $card->name ?? '' }}">
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price<span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            autocomplete="off" placeholder="Enter price" value="{{ $card->price ?? '' }}">
                                        @if($errors->has('price'))
                                            <span class="text-danger">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Discount Price<span
                                                class='text-info'> (Optional)</span></label>
                                        <input type="number" class="form-control" id="price" name="discount_price"
                                            autocomplete="off" placeholder="Enter discount price" value="{{ $card->discount_price ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Front Image</label>
                                        <input type="file" class="form-control" id="image" name="front_image"
                                            autocomplete="off" onchange="previewImages(event)"  accept="image/*">
                                        @if($errors->has('front_image'))
                                            <span class="text-danger">{{ $errors->first('front_image') }}</span>
                                        @endif
                                    </div>
                                    <div id="imagePreview" class="my-4"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Back Image</label>
                                        <input type="file" class="form-control" id="image" name="back_image"
                                            autocomplete="off" onchange="previewBackImages(event)"  accept="image/*">
                                        @if($errors->has('back_image'))
                                            <span class="text-danger">{{ $errors->first('back_image') }}</span>
                                        @endif
                                    </div>
                                    <div id="backImagePreview" class="my-4"></div>
                                </div>


                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="tinymceExample" cols="30" rows="10">{{ $card->description ?? '' }}</textarea>
                                    @if($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>



                                <div class="mb-3">
                                    <div class="form-check">
                                        <label class="form-check-label" for="termsCheck">Active</label>
                                        <input type="checkbox" class="form-check-input" name="status"
                                            id="termsCheck" {{ $card->status == 0 ? 'checked' : '' }}>
                                        @if($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('js')
    <script>
        // front image
        function previewImages(event) {
            let files = event.target.files;
            document.getElementById('imagePreview').innerHTML = '';
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 300;
                    img.height = 200;
                    document.getElementById('imagePreview').appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
        // back image
        function previewBackImages(event) {
            let files = event.target.files;
            document.getElementById('backImagePreview').innerHTML = '';
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 300;
                    img.height = 200;
                    document.getElementById('backImagePreview').appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
