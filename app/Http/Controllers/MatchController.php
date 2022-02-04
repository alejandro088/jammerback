<?php

namespace App\Http\Controllers;

use App\Models\MatchUsers;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function match(Request $request)
    {
        $user = auth()->user();

        if ($match = MatchUsers::where('user_id_to', $request->user_id)->where('user_id_from', $user->id)->first()) {

            $match->status = 1;
            $match->replied_at = now();
            $match->save();
    
            return response()->json([
                'message' => 'Match accepted',
            ], 200);
        }

        MatchUsers::create([
            'user_id_to' => $user->id,
            'user_id_from' => $request->user_id,
            'status' => 0,
            'requested_at' => now()
        ]);

        return response()->json(['message' => 'Match request sent']);
    }

    public function accept(Request $request)
    {
        $user = auth()->user();

        $match = MatchUsers::where('user_id_from', $user->id)
            ->where('user_id_to', $request->user_id)
            ->first();

        if (!$match) {
            return response()->json(['message' => 'No match found'], 404);
        }

        $match->status = 1;
        $match->replied_at = now();
        $match->save();

        return response()->json(['message' => 'Match accepted']);
    }
}
