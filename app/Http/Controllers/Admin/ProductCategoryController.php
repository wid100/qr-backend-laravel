<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_category = ProductCategory::all();
        return view('admin.product_category.index', compact('product_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',

        ]);

        $status = $request->has('status') ? true : false;
        $product_category = new ProductCategory();
        $product_category->name = $validatedData['name'];
        $product_category->status = $status;

        $product_category->save();

        return redirect()->route('admin.product_category.index')->with('success', 'Product Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product_category = ProductCategory::find($id);
        return view('admin.product_category.edit', compact('product_category'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $status = $request->has('status') ? 1 : 0;
        $product_category = ProductCategory::findOrFail($id);
        $product_category->name = $validatedData['name'];
        $product_category->status = $status;

        $product_category->save();

        return redirect()->route('admin.product_category.index')->with('success', 'Product Category Update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_category = ProductCategory::find($id);
        $product_category->delete();
        return redirect()->back()->with('success', 'Product Category Delete Success');
    }
}
