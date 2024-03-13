<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PackageController extends Controller
{

    // public function filterByCountry(Request $request)
    // {
    //     $countryId = $request->input('country_id');
    //     $packages = Package::where('country_id', $countryId)->get();
    //     return response()->json($packages);
    // }

    public function filterByCountry(Request $request)
    {
        // Retrieve the country name from the request
        $countryName = trim($request->input('country_name'));

        // Log the country name for debugging
        logger('Country Name:', ['name' => $countryName]);

        // Find the country by name
        $country = Country::where('name', $countryName)->first();

        // Check if the country exists
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        // Get the country ID
        $countryId = $country->id;

        // Retrieve packages associated with the specified country
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
