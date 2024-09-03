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
                                        <label for="category_id" class="form-label">Category <span
                                                class='text-danger'>*</span></label>
                                        <select id="category_id" name="category_id" class=" form-control form-select-lg"
                                            required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sub_category_id" class="form-label">Sub Category </label>
                                        <select id="sub_category_id" name="sub_category_id"
                                            class="form-control form-select-lg">
                                            <option value="">Select Sub Category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sub_sub_category_id" class="form-label">Sub Sub Category</label>
                                        <select id="sub_sub_category_id" name="sub_sub_category_id"
                                            class="form-control form-select-lg">
                                            <option value="">Select Sub Sub Category</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="brand_id" class="form-label">Brands Name<span
                                                class='text-danger'>*</span></label>
                                        <select id="brand_id" name="brand_id"
                                            class="js-example-basic-single form-control form-select" required>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock_quantity" class="form-label">Stock Quantity <span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity"
                                            autocomplete="off" placeholder="Enter stock quantity">
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
                                        <label for="discount_price" class="form-label">Discount Price <span
                                                class='text-danger'>*</span></label>
                                        <input type="number" class="form-control" id="discount_price"
                                            name="discount_price" autocomplete="off" placeholder="Enter Discount price">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">

                                        <div class="form-group">
                                            <label for="stock_quantity" class="form-label">Size <span
                                                    class='text-danger'>*</span></label>
                                            <div>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Price</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sizeTableBody">
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="sizes[0][name]" placeholder="Name">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    name="sizes[0][price]" placeholder="Price">
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-success" type="button"
                                                                    onclick="addSize()">Add</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image </label>
                                        <input type="file" class="form-control" id="image" name="image[]"
                                            autocomplete="off" onchange="previewImages(event)" multiple accept="image/*">
                                    </div>
                                    <div id="imagePreview" class="my-4"></div>
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
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control" name="short_description" id="tinymceExample" cols="30" rows="6"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="tinymceExample" cols="30" rows="10"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="additional_information" class="form-label">Additional Information</label>
                                    <textarea class="form-control" name="additional_information" id="tinymceExample" cols="30" rows="10"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_returns" class="form-label">Shipping Returns</label>
                                    <textarea class="form-control" name="shipping_returns" id="tinymceExample" cols="30" rows="10"></textarea>
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




{{-- @section('js')
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
        // Add Size input fiuld
        let sizeIndex = 1;

        function addSize() {
            const tableBody = document.getElementById('sizeTableBody');

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
        <td>
            <input type="text" class="form-control" name="sizes[${sizeIndex}][name]" placeholder="Name">
        </td>
        <td>
            <input type="text" class="form-control" name="sizes[${sizeIndex}][price]" placeholder="Price">
        </td>
        <td>
            <button class="btn btn-danger" type="button" onclick="deleteRow(this)">Delete</button>
        </td>
    `;
            tableBody.appendChild(newRow);
            sizeIndex++;
        }

        function deleteRow(button) {
            const row = button.closest('tr');
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