<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Instrument;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class InstrumentController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth:api', ['except' => ['get']]
        );
    }

    public function get(): JsonResponse
    {
        $instruments = Instrument::all();
        return response()->json(['instrument' => $instruments]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $instrument = new Instrument();
        $instrument->name = $request->name;
        $instrument->save();

        if(!$instrument) return response()->json(['msg' => 'Error', 'instrument' => $instrument], Response::HTTP_NOT_FOUND);

        return response()->json(['instrument' => $instrument]);
    }
}
