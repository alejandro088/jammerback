<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Genre;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth:api', ['except' => ['get']]
        );
    }

    public function get(): JsonResponse
    {
        $genres = Genre::all();
        return response()->json(['genre' => $genres]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $genre = new Genre();
        $genre->name = $request->name;
        $genre->save();

        if(!$genre) return response()->json(['msg' => 'Error', 'instrument' => $genre], Response::HTTP_NOT_FOUND);

        return response()->json(['instrument' => $genre]);

    } 
}
