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
}
