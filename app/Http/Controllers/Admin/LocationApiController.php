<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Neighborhood;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    public function cities(): JsonResponse
    {
        $cities = City::orderBy('name')->get(['id', 'name']);
        return response()->json($cities);
    }

    public function districts(Request $request): JsonResponse
    {
        $cityId = $request->get('city_id');
        if (! $cityId) {
            return response()->json([]);
        }
        $districts = District::where('city_id', $cityId)->orderBy('name')->get(['id', 'name', 'city_id']);
        return response()->json($districts);
    }

    public function neighborhoods(Request $request): JsonResponse
    {
        $districtId = $request->get('district_id');
        if (! $districtId) {
            return response()->json([]);
        }
        $neighborhoods = Neighborhood::where('district_id', $districtId)->orderBy('name')->get(['id', 'name', 'district_id']);
        return response()->json($neighborhoods);
    }
}
