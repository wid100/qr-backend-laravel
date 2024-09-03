<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    // public function productImageSortable(Request $request)
    // {
    //     if (!empty($request->photo_id)) {
    //         $i = 1;
    //         foreach ($request->photo_id as $photo_id) {
    //             $image = ProductImage::find($photo_id);
    //             $image->order_by = $i;
    //             $image->save();
    //             $i++;
    //         }
    //         return response()->json(['success' => true]);
    //     } else {
    //         return response()->json(['success' => false, 'message' => 'No photo IDs provided']);
    //     }
    // }

    public function index()
    {
        $data['header_title'] = 'Product';
        $products = Product::get();
        return view('admin.product.index', compact('products'), $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['header_title'] = 'Create Product';
        $categories = ProductCategory::orderBy("created_at", "desc")->get();
        return view('admin.product.create', compact('categories', 'brands', 'colors'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required',
    //         'category_id' => 'required',
    //         'buy_price' => 'required',
    //         'price' => 'required',
    //         'quantity' => 'required',
    //         'meta_title' => 'nullable',
    //         'meta_keywords' => 'nullable',
    //         'meta_description' => 'nullable',
    //         'description' => 'nullable',
    //         'color_id' => 'array|nullable',
    //         'image' => 'array|nullable',
    //         'sizes' => 'array|nullable',
    //         'sizes.*.name' => 'nullable',
    //         'sizes.*.price' => 'nullable',

    //     ]);

    //     $product = new Product();
    //     $product->title = $validatedData['title'];
    //     $product->slug = Str::slug($validatedData['title']);
    //     $product->category_id = $validatedData['category_id'];
    //     $product->sub_category_id = $validatedData['sub_category_id'];
    //     $product->sub_sub_category_id = $validatedData['sub_sub_category_id'];
    //     $product->brand_id = $validatedData['brand_id'];
    //     $product->buy_price = $validatedData['buy_price'];
    //     $product->price = $validatedData['price'];
    //     $product->discount_price = $validatedData['discount_price'];
    //     $product->stock_quantity = $validatedData['stock_quantity'];
    //     $product->meta_title = $validatedData['meta_title'];
    //     $product->meta_keywords = $validatedData['meta_keywords'];
    //     $product->meta_description = $validatedData['meta_description'];
    //     $product->short_description = $validatedData['short_description'];
    //     $product->description = $validatedData['description'];
    //     $product->additional_information = $validatedData['additional_information'];
    //     $product->shipping_returns = $validatedData['shipping_returns'];
    //     $product->status = $request->has('status') ? true : false;
    //     $product->save();

    //     if (!empty($validatedData['color_id'])) {
    //         foreach ($validatedData['color_id'] as $color_id) {
    //             $color = new ProductColor();
    //             $color->color_id = $color_id;
    //             $color->product_id = $product->id;
    //             $color->save();
    //         }
    //     }



    //     if (!empty($validatedData['sizes'])) {
    //         foreach ($validatedData['sizes'] as $size) {
    //             $productSize = new ProductSize();
    //             $productSize->name = $size['name'];
    //             $productSize->price = $size['price'];
    //             $productSize->product_id = $product->id;
    //             $productSize->save();
    //         }
    //     }

    //     if ($request->hasFile('image')) {
    //         foreach ($request->file('image') as $file) {
    //             $imageName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
    //             $file->move(public_path('admin/assets/images/product'), $imageName);

    //             $image = new ProductImage();
    //             $image->image_name = 'admin/assets/images/product/' . $imageName;
    //             $image->product_id = $product->id;
    //             $image->save();
    //         }
    //     }
    //     return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    // }

    // /**
    //  * Display the specified resource.
    //  */

    // public function show(Product $product)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit($id)
    // {
    //     $data['header_title'] = 'Edit Product';
    //     $product = Product::find($id);
    //     $categories = Category::orderBy("created_at", "desc")->get();
    //     $sub_categories = SubCategory::orderBy("created_at", "desc")->get();
    //     $sub_sub_categories = SubSubCategory::orderBy("created_at", "desc")->get();
    //     $brands = Brand::orderBy("created_at", "desc")->get();
    //     $colors = Color::orderBy("created_at", "desc")->get();
    //     return view('admin.product.edit', compact('product', 'categories', 'brands', 'colors', 'sub_categories', 'sub_sub_categories'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required',
    //         'category_id' => 'required',
    //         'sub_category_id' => 'nullable',
    //         'sub_sub_category_id' => 'nullable',
    //         'brand_id' => 'required',
    //         'buy_price' => 'required',
    //         'price' => 'required',
    //         'discount_price' => 'required',
    //         'stock_quantity' => 'required',
    //         'meta_title' => 'nullable',
    //         'meta_keywords' => 'nullable',
    //         'meta_description' => 'nullable',
    //         'short_description' => 'nullable',
    //         'description' => 'nullable',
    //         'additional_information' => 'nullable',
    //         'shipping_returns' => 'nullable',
    //         'color_id' => 'array|nullable',
    //         'sizes' => 'array|nullable',
    //         'sizes.*.name' => 'nullable',
    //         'sizes.*.price' => 'nullable',
    //         'image' => 'array|nullable',
    //         'image.*' => 'nullable',
    //     ]);

    //     $product = Product::findOrFail($id);
    //     $product->title = $validatedData['title'];
    //     $product->slug = Str::slug($validatedData['title']);
    //     $product->category_id = $validatedData['category_id'];
    //     $product->sub_category_id = $validatedData['sub_category_id'];
    //     $product->sub_sub_category_id = $validatedData['sub_sub_category_id'];
    //     $product->brand_id = $validatedData['brand_id'];
    //     $product->buy_price = $validatedData['buy_price'];
    //     $product->price = $validatedData['price'];
    //     $product->discount_price = $validatedData['discount_price'];
    //     $product->stock_quantity = $validatedData['stock_quantity'];
    //     $product->meta_title = $validatedData['meta_title'];
    //     $product->meta_keywords = $validatedData['meta_keywords'];
    //     $product->meta_description = $validatedData['meta_description'];
    //     $product->short_description = $validatedData['short_description'];
    //     $product->description = $validatedData['description'];
    //     $product->additional_information = $validatedData['additional_information'];
    //     $product->shipping_returns = $validatedData['shipping_returns'];
    //     $product->status = $request->has('status') ? true : false;
    //     $product->save();

    //     if (!empty($validatedData['color_id'])) {
    //         $product->productColors()->delete();
    //         foreach ($validatedData['color_id'] as $color_id) {
    //             $color = new ProductColor();
    //             $color->color_id = $color_id;
    //             $color->product_id = $product->id;
    //             $color->save();
    //         }
    //     }

    //     if (!empty($validatedData['sizes'])) {
    //         $product->productSizes()->delete();
    //         foreach ($validatedData['sizes'] as $size) {
    //             $productSize = new ProductSize();
    //             $productSize->name = $size['name'];
    //             $productSize->price = $size['price'];
    //             $productSize->product_id = $product->id;

    //             $productSize->save();
    //         }
    //     }

    //     // Delete old images
    //     $productImages = $product->productImages;
    //     foreach ($productImages as $productImage) {
    //         if (file_exists(public_path($productImage->image_name))) {
    //             unlink(public_path($productImage->image_name));
    //         }
    //         $productImage->delete();
    //     }

    //     // Upload new images
    //     if ($request->hasFile('image')) {
    //         foreach ($request->file('image') as $file) {
    //             $imageName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
    //             $file->move(public_path('admin/assets/images/product'), $imageName);

    //             $image = new ProductImage();
    //             $image->image_name = 'admin/assets/images/product/' . $imageName;
    //             $image->product_id = $product->id;
    //             $image->save();
    //         }
    //     }
    //     return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    // }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}