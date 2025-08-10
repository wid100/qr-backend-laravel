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
        $countryName = trim($request->input('country_name'));

        // Log the country name
        logger('Country Name:', ['name' => $countryName]);

        // Check if the country name is provided
        if (empty($countryName)) {
            return response()->json(['error' => 'Country name is required'], 400);
        }

        // Find the country by name
        $country = Country::where('name', $countryName)->first();

        // If the country is not found, return an error
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        // Get the country ID
        $countryId = $country->id;

        // Retrieve packages by country ID and status
        $packages = Package::where('country_id', $countryId)
            ->where('status', 1)
            ->get();

        // Return the packages as JSON
        return response()->json($packages);
    }








    public function show($id)
    {
        // return response()->json('hi');
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
