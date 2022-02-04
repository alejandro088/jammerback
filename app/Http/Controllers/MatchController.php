<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                'user' => User::find($request->user_id),
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

        return response()->json(['message' => 'Match accepted', 'user' => User::find($request->user_id),]);
    }

    public function next_user_randomize()
    {
        $user = auth()->user();

        // ger random user
        $user = User::where('id', '!=', $user->id)->inRandomOrder()->first();

        return response()->json([
            'user' => $user
        ]);
    }

    public function next_user_preference()
    {
        $user = auth()->user();

        //dd($user->instruments);

        // get user with highest preference
        $user = User::where('id', '!=', $user->id)
            ->where('availability', $user->availability)
            ->where('long_term', $user->long_term)
            ->whereDoesntHave('matches', function ($query) use ($user) {
                $query->where('user_id_to', $user->id);
            })
            ->whereHas('instruments', function ($query) use ($user) {
                if ($user->instruments->first()) {
                    $query->where('instruments.id', $user->instruments->first()->id);
                }
            })
            ->whereHas('genres', function ($query) use ($user) {
                if ($user->genres->first()) {
                    $query->where('genres.id', $user->genres->first()->id);
                }
            })
            ->inRandomOrder()
            ->first();

        return response()->json([
            'user' => $user
        ]);
    }	
}
