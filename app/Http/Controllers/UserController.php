<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth:api', ['except' => ['get_all','get_user']]
        );
    }
    public function get_all()
    {
        $users = User::all();
        return response()->json(['user' => $users]);
    }

    public function get_user($id)
    {
        $user = User::find($id);
        return response()->json(['user' => $user]);
    }
}
