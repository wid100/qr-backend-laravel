@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Edit Product</h6>
                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span
                                                class='text-danger'>*</span></label>
                                        <input type="text" class="form-control" id="title"
                                            value="{{ $product->title }}" name="title" autocomplete="off"
                                            placeholder="Enter Title">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_category_id" class="form-label">Category <span
                                                class='text-danger'>*</span></label>
                                        <select id="product_category_id" name="product_category_id"
                                            class=" form-control form-select-lg" required>

                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $product->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock_quantity" class="form-label">Color <span
                                                class='text-danger'>*</span></label>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach ($colors as $color)
                                                @php
                                                    $checked = '';
                                                @endphp
                                                @if ($product->productColors)
                                                    @foreach ($product->productColors as $pcolor)
                                                        @if ($pcolor->color_id == $color->id)
                                                            @php
                                                                $checked = 'checked';
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <label>
                                                    <input type="checkbox" {{ $checked }} name="color_id[]"
                                                        id="{{ $color->id }}" value="{{ $color->id }}">
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
                                        <input type="number" class="form-control" id="buy_price"
                                            value="{{ $product->buy_price }}" name="buy_price" autocomplete="off"
                                            placeholder="Enter Buy Price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price <span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="price"
                                            value="{{ $product->price }}" name="price" autocomplete="off"
                                            placeholder="Enter Price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity <span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="quantity"
                                            value="{{ $product->quantity }}" name="quantity" autocomplete="off"
                                            placeholder="Enter quantity">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image[]"
                                            autocomplete="off" multiple accept="image/*">
                                    </div>
                                    @if ($product->productImages->count())
                                        <div class="row" id="sortable">
                                            @foreach ($product->productImages as $image)
                                                <div class="col-md-2 position-relative sortable_image"
                                                    id="{{ $image->id }}">
                                                    <img src="{{ asset($image->image_name) }}" alt=""
                                                        class="img-thumbnail">
                                                    {{-- <a href="{{ route('admin.product.image.delete', $image->id) }}" class="btn btn-danger btn-sm position-absolute top-0 end-0">Delete</a> --}}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="tinymceExample" cols="30" rows="10"> {{ $product->description }}</textarea>
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control" id="meta_title"
                                            value="{{ $product->meta_title }}" name="meta_title" autocomplete="off"
                                            placeholder="Enter Meta Title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control" value="{{ $product->meta_keywords }}"
                                            id="meta_keywords" name="meta_keywords" autocomplete="off"
                                            placeholder="Enter meta keywords">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control" name="meta_description" value="{{ $product->meta_description }}" id="tinymceExample"
                                            cols="30" rows="7">{{ $product->meta_description }}</textarea>
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
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


{{-- @section('js')
    <script>
        $(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var photo_id = [];
                    $('.sortable_image').each(function() {
                        var id = $(this).attr('id');
                        photo_id.push(id);
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/product_image_sortable') }}",
                        data: {
                            "photo_id": photo_id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                console.log('Order updated successfully');
                            }
                        },
                        error: function(data) {
                            console.error('Error:', data);
                        }
                    });
                }
            });
        });


        function previewImages(event) {
            let files = event.target.files;
            document.getElementById('imagePreview').innerHTML = '';
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = 100;
                    img.height = 100;
                    document.getElementById('imagePreview').appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
        // Add Size input fiuld

        let sizeIndex = {{ $product->productSizes ? $product->productSizes->count() : 0 }};

        function addSize() {
            let sizeTableBody = document.getElementById('sizeTableBody');
            let newRow = document.createElement('tr');

            newRow.innerHTML = `
                                                        <td>
                                                            <input type="hidden" name="sizes[${sizeIndex}][id]" value="">
                                                            <input type="text" class="form-control" name="sizes[${sizeIndex}][name]" placeholder="Name">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="sizes[${sizeIndex}][price]" placeholder="Price">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger" type="button" onclick="deleteRow(this)">Delete</button>
                                                        </td>
                                                        `;

            sizeTableBody.appendChild(newRow);
            sizeIndex++;
        }

        function deleteRow(button) {
            let row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }




        // Category
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const subCategorySelect = document.getElementById('sub_category_id');
            const subSubCategorySelect = document.getElementById('sub_sub_category_id');

            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                fetch(`{{ url('/admin/get-sub-categories') }}/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                        data.forEach(subCategory => {
                            subCategorySelect.innerHTML +=
                                `<option value="${subCategory.id}">${subCategory.name}</option>`;
                        });
                    })
                    .catch(error => console.error('Error fetching sub-categories:', error));
            });

            subCategorySelect.addEventListener('change', function() {
                const subCategoryId = this.value;
                fetch(`{{ url('/admin/get-sub-sub-categories') }}/${subCategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        subSubCategorySelect.innerHTML =
                            '<option value="">Select Sub Sub Category</option>';
                        data.forEach(subSubCategory => {
                            subSubCategorySelect.innerHTML +=
                                `<option value="${subSubCategory.id}">${subSubCategory.name}</option>`;
                        });
                    })
                    .catch(error => console.error('Error fetching sub-sub categories:', error));
            });
        });
    </script>
@endsection --}}
