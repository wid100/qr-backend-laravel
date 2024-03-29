<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('admin.package.index', compact('packages'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countres = Country::all();
        return view('admin.package.create', compact('countres'));
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
            'name' => 'required|string|max:255',
            'qr_qt' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'scan_limit' => 'nullable|string|max:255',
            'website_qr_limit' => 'nullable|string|max:255',
            'ecommerch_limit' => 'nullable|string|max:255',
            'card' => 'nullable|string|max:255',
            'price' => 'required',
            'description' => 'nullable|string',
        ]);

        $status = $request->has('status') ? 1 : 0;
        $package = new Package();
        $package->name = $validatedData['name'];
        $package->country_id = $validatedData['country'];
        $package->qr_qt = $validatedData['qr_qt'];
        $package->scan_limit = $validatedData['scan_limit'];
        $package->website_qr_limit = $validatedData['website_qr_limit'];
        $package->ecommerch_limit = $validatedData['ecommerch_limit'];
        $package->card = $validatedData['card'];
        $package->price = $validatedData['price'];
        $package->description = $validatedData['description'];
        $package->status = $status;

        $package->save();

        return redirect()->route('admin.package.index')->with('success', 'Package created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);
        $countres = Country::all();
        return view('admin.package.edit', compact('countres', 'package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'qr_qt' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'scan_limit' => 'nullable|string|max:255',
            'website_qr_limit' => 'nullable|string|max:255',
            'ecommerch_limit' => 'nullable|string|max:255',
            'card' => 'nullable|string|max:255',
            'price' => 'required',
            'description' => 'nullable|string',
        ]);

        $status = $request->has('status') ? 1 : 0;

        $package = Package::findOrFail($id);
        $package->name = $validatedData['name'];
        $package->country_id = $validatedData['country'];
        $package->qr_qt = $validatedData['qr_qt'];
        $package->scan_limit = $validatedData['scan_limit'];
        $package->website_qr_limit = $validatedData['website_qr_limit'];
        $package->ecommerch_limit = $validatedData['ecommerch_limit'];
        $package->card = $validatedData['card'];
        $package->price = $validatedData['price'];
        $package->description = $validatedData['description'];
        $package->status = $status;

        $package->save();

        return redirect()->route('admin.package.index')->with('success', 'Package updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->back()->with('success', 'Package Delete Success');
    }
}
