<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Location;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth:api', ['except' => ['get']]
        );
    }

    public function get(): JsonResponse
    {
        $locations = Location::all();
        return response()->json(['locations' => $locations]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $location = new Location();
        $location->name = $request->name;
        $location->save();

        if(!$location) return response()->json(['msg' => 'Error', 'location' => $location], Response::HTTP_NOT_FOUND);

        return response()->json(['location' => $location]);
    }
}
