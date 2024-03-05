<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Package;
use Illuminate\Http\Request;


class PackageController extends Controller
{

    public function filterByCountry(Request $request)
    {
        $countryId = $request->input('country_id');
        $packages = Package::where('country_id', $countryId)->get();
        return response()->json($packages);
    }


    public function show($id)
    {
        $package = Package::where('id', $id)->first();
        if (!$package) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }


        if ($package->status == 1) {
            return response()->json($package);
        } else {
            return response()->json(['error' => 'Qrgen is paused'], 403);
        }
    }
}
