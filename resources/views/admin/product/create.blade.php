@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Product</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Create Product</h6>

                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span
                                                class='text-danger'>*</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            autocomplete="off" placeholder="Enter Title" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_category_id" class="form-label">Product Category <span
                                                class='text-danger'>*</span></label>
                                        <select id="product_category_id" name="product_category_id"
                                            class=" form-control form-select-lg" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="color_id" class="form-label">Color <span
                                                class='text-danger'>*</span></label>
                                        <div class=" d-flex flex-wrap gap-3">
                                            @foreach ($colors as $color)
                                                <label for="{{ $color->id }}">
                                                    <input type="checkbox" name="color_id[]" id="{{ $color->id }}"
                                                        value="{{ $color->id }}">
                                                    {{ $color->name }}
                                                </label>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="buy_price" class="form-label">Buy Price <span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="buy_price" name="buy_price"
                                            autocomplete="off" placeholder="Enter Buy Price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price <span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            autocomplete="off" placeholder="Enter Price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity <span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                            autocomplete="off" placeholder="Enter stock quantity">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image </label>
                                        <input type="file" class="form-control" id="image" name="image[]"
                                            autocomplete="off" onchange="previewImages(event)" multiple accept="image/*">
                                    </div>
                                    <div id="imagePreview" class="my-4"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="tinymceExample" cols="30" rows="10"></textarea>
                                </div>

                                <hr>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            autocomplete="off" placeholder="Enter Meta Title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" id="meta_keywords"
                                            name="meta_keywords" autocomplete="off" placeholder="Enter meta keywords">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" id="tinymceExample" cols="30" rows="7"></textarea>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <label class="form-check-label" for="termsCheck">Active</label>
                                        <input type="checkbox" class="form-check-input" checked name="status"
                                            id="termsCheck">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2">Create</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('js')
    <script>
        function previewImages(event) {
            let files = event.target.files;
            document.getElementById('imagePreview').innerHTML = '';
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 150;
                    img.height = 150;
                    document.getElementById('imagePreview').appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
