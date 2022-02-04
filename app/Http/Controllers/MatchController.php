<?php

namespace App\Http\Controllers;

use App\Models\MatchUsers;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function match(Request $request)
    {
        $user = auth()->user();

        MatchUsers::create([
            'user_id_to' => $user->id,
            'user_id_from' => $request->user_id,
            'status' => 0,
            'requested_at' => now()
        ]);

        return response()->json(['message' => 'Match request sent']);
    }
}
