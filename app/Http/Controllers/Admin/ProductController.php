<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductImage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function productImageSortable(Request $request)
    {
        if (!empty($request->photo_id)) {
            $i = 1;
            foreach ($request->photo_id as $photo_id) {
                $image = ProductImage::find($photo_id);
                $image->order_by = $i;
                $image->save();
                $i++;
            }
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'No photo IDs provided']);
        }
    }

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
        $colors = Color::orderBy("created_at", "desc")->get();
        return view('admin.product.create', compact('categories', 'colors'), $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'product_category_id' => 'required',
            'buy_price' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
            'description' => 'nullable',
            'color_id' => 'array|nullable',
            'image' => 'array|nullable',

        ]);

        $product = new Product();
        $product->title = $validatedData['title'];
        $product->slug = Str::slug($validatedData['title']);
        $product->product_category_id = $validatedData['product_category_id'];
        $product->buy_price = $validatedData['buy_price'];
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];
        $product->meta_title = $validatedData['meta_title'];
        $product->meta_keywords = $validatedData['meta_keywords'];
        $product->meta_description = $validatedData['meta_description'];
        $product->description = $validatedData['description'];
        $product->status = $request->has('status') ? true : false;
        $product->save();
        if (!empty($validatedData['color_id'])) {
            foreach ($validatedData['color_id'] as $color_id) {
                $color = new ProductColor();
                $color->color_id = $color_id;
                $color->product_id = $product->id;
                $color->save();
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $imageName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/product'), $imageName);

                $image = new ProductImage();
                $image->image_name = 'assets/images/product/' . $imageName;
                $image->product_id = $product->id;
                $image->save();
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

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
    public function edit($id)
    {
        $data['header_title'] = 'Edit Product';
        $product = Product::find($id);
        $categories = ProductCategory::orderBy("created_at", "desc")->get();
        $colors = Color::orderBy("created_at", "desc")->get();
        return view('admin.product.edit', compact('product', 'categories', 'colors'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'product_category_id' => 'required',
            'buy_price' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'meta_title' => 'nullable',
            'meta_keywords' => 'nullable',
            'meta_description' => 'nullable',
            'description' => 'nullable',
            'color_id' => 'array|nullable',
            'image' => 'array|nullable',
            'image.*' => 'nullable',
        ]);

        $product = Product::findOrFail($id);
        $product->title = $validatedData['title'];
        $product->slug = Str::slug($validatedData['title']);
        $product->product_category_id = $validatedData['product_category_id'];
        $product->buy_price = $validatedData['buy_price'];
        $product->price = $validatedData['price'];
        $product->quantity = $validatedData['quantity'];
        $product->meta_title = $validatedData['meta_title'];
        $product->meta_keywords = $validatedData['meta_keywords'];
        $product->meta_description = $validatedData['meta_description'];
        $product->description = $validatedData['description'];
        $product->status = $request->has('status') ? true : false;
        $product->save();

        // Handle images only if new images are uploaded
        if ($request->hasFile('image')) {
            // Delete old images
            $productImages = $product->productImages;
            foreach ($productImages as $productImage) {
                if (file_exists(public_path($productImage->image_name))) {
                    unlink(public_path($productImage->image_name));
                }
                $productImage->delete();
            }

            // Upload new images
            foreach ($request->file('image') as $file) {
                $imageName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/images/product'), $imageName);

                $image = new ProductImage();
                $image->image_name = 'assets/images/product/' . $imageName;
                $image->product_id = $product->id;
                $image->save();
            }
        }
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $productImages = $product->productImages;
        foreach ($productImages as $productImage) {
            if (file_exists(public_path($productImage->image_name))) {
                unlink(public_path($productImage->image_name));
            }
            $productImage->delete();
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}