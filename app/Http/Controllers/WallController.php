<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Wall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WallController extends Controller
{
    public function read()
    {
        $walls = Wall::all();

        foreach ($walls as $wall) {
            $like = Like::where('wall_id', $wall->id);
            $wall['likes'] = $like->count();
            $wall['liked'] = !empty($like->firstWhere('user_id', Auth::id()));
        }

        return [
            'error' => '',
            'list' => $walls,
        ];
    }

    public function like($id)
    {
        $wall = Wall::find($id);
        if (empty($wall)) return redirect()->route('login');

        $authId = Auth::id();
        $likes = Like::where('wall_id', $id);
        $like = $likes->firstWhere('user_id', $authId);

        if ($liked = empty($like)) {
            Like::create([
                'wall_id' => $id,
                'user_id' => $authId,
            ]);
        } else {
            $like->delete();
        }

        return [
            'error' => '',
            'likes' => $likes->count(),
            'liked' => $liked,
        ];
    }
}
