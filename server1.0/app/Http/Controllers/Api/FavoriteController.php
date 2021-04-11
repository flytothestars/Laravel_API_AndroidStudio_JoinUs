<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function favorite(Request $request){
        $favorite = Favorite::where('event_id', $request->id)->where('user_id', Auth::user()->id)->get();

        if(count($favorite) > 0){
            $favorite[0]->delete();
            return response()->json([
                'success' => true,
                'message' => 'unliked'
            ]);
        }

        $favorite = new Favorite;
        $favorite->user_id = Auth::user()->id;
        $favorite->event_id = $request->id;
        $favorite->save();

        return response()->json([
            'success' => true,
            'message' => 'liked'
        ]);

    }
}
