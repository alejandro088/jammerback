<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth:api', ['except' => ['get_all','get_user']]
        );
    }
    public function get_all(): JsonResponse
    {
        $users = User::all();
        return response()->json(['user' => $users]);
    }

    public function get_user($id): JsonResponse
    {
        $user = User::find($id);
        return response()->json(['user' => $user]);
    }

    public function complete_profile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'description'=> ['required', 'string', 'max:255'],
            'phone' => ['required', 'integer'],
            'location_id' => ['required', 'integer'],
            'availability' => ['required', 'string', 'max:100'],
            'type' => ['required', 'integer'],
            'long_term' => ['required', 'boolean'],
            'profile_image' => ['string', 'max:255'],
            'user_id' => ['required', 'integer']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($request->user_id);
        $user->description = $request->description;
        $user->phone = $request->phone;
        $user->location_id = $request->location_id;
        $user->availability = $request->availability;
        $user->type = $request->type;
        $user->long_term = $request->long_term;
        $user->profile_image = $request->profile_image;
        $user->save();

        if(!$user) return response()->json(['msg' => 'User not found'], Response::HTTP_NOT_FOUND);

        return response()->json(['user' => $user]);
    }
}
