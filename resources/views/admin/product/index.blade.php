@extends('master.master')

@section('content')
    <div class="page-content">
        <nav class="page-breadcrumb d-flex align-center justify-content-between">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product List Table</li>
            </ol>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary"> Create
                product</a>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Admin List Table</h6>
                        <div class="table-responsive">

                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>

                                        <th>Category Name</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Buy Price</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>
                                                @if ($product->productCategorys)
                                                    {{ $product->productCategorys->name }}
                                                @else
                                                    No Category
                                                @endif
                                            </td>
                                            <td>{{ $product->title }}</td>

                                            <td>
                                                {!! Str::limit(strip_tags($product->description), 30, '...') !!}
                                            </td>
                                            <td>
                                                @if ($product->productImages->isNotEmpty())
                                                    <img src="{{ $product->productImages->first()->getImage() }}"
                                                        alt="{{ $product->title }}" width="100">
                                                @else
                                                    No Image
                                                @endif

                                            </td>
                                            <td>{{ $product->buy_price }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->quantity }}</td>
                                            <td>
                                                @if ($product->status === 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-primary">De Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('admin.product.edit', $product->id) }}"
                                                        class="btn btn-primary btn-icon">

                                                        <i data-feather="edit"></i></a>

                                                    @if (Auth::user()->role_id == 1)
                                                        <form id="delete_form_{{ $product->id }}"
                                                            action="{{ route('admin.product.destroy', $product->id) }}"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-danger btn-icon delete-button"
                                                                onclick="deleteId({{ $product->id }})">
                                                                <i data-feather="trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
