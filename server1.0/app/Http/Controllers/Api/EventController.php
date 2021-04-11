<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Event;

class EventController extends Controller
{
    public function create(Request $request){
        
        $event = new Event;
        $event->user_id = Auth::user()->id;
        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->location = $request->location;
        $event->date = $request->date;
        $event->price = $request->price;
        
        if($request->photo != ''){
            $photo = time().'.jpg';
            file_put_contents('storage/events/'.$photo,base64_decode($request->photo));
            $event->photo = $photo;
        }
        
        $event->save();
        $event->user;
        return response()->json([
            'success' => true,
            'message' => 'posted',
            'post' => $event
        ]);

    }

    public function update(Request $request){
        $event = Event::find($request->id);
        if(Auth::user()->id != $event->user_id){
            return response()->json([
                'success' => false,
                //'user_id' => Auth::user()->id,
                //'event_id_user' => $event->user_id,
                'message' => 'unauthorized access'
            ]);
        }

        $event->title = $request->title;
        $event->desc = $request->desc;
        $event->location = $request->location;
        $event->date = $request->date;
        $event->price = $request->price;

        $event->update();
        return response()->json([
            'success' => true,
            'message' => 'event edited'
        ]);
    }

    public function delete(Request $request){
        $event = Event::find($request->id);
        if(Auth::user()->id != $event->user_id){
            return response()->json([
                'success' => false,
                //'id' => Auth::user()->id + ' ' + $event->user_id + ' ' + $request->id,
                'message' => 'unauthorized access'
            ]);
        }

        if($event->photo != ''){
            Storage::delete('public/events/'.$event->photo);
        }

        $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'event deleted'
        ]);
    }

    public function events(){
        $events = Event::orderBy('id','desc')->get();
        foreach($events as $event){
            //get User post
            $event->user;
            //comments count
            $event['commentCount'] = count($event->comments);
            //likes count
            $event['favoritesCount'] = count($event->favorites);

            $event['selfFavorites'] = false;
            foreach($event->favorites as $favorite){
                if($favorite->user_id == Auth::user()->id){
                    $favorite['selfFavorites'] = false;        
                }
            }
        }

        return response()->json([
            'success' => true,
            'events' => $events
        ]);
    }
}
