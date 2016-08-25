<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;
use DB;
use Auth;
use App\Image;

class EventsController extends Controller
{

  /* Require any user attempting to authenticate social media
   * to be logged in
   */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*

      This function routes to the create Event page

    */
    public function createEvent() {

      return view('pages.createEvent');

    }

    /*
      This function creates a new Event in the database after validating them
    */
    protected function store(Request $request)
    {
        $this->validate($request, [
            'eventName' => 'required|unique:events,eventName',
            'pointType' => 'required',
            'points' => 'required|between:0,9',
            'date' => 'required',
            'image' => 'image',
        ]);

        //creating the thumbnail
        //TODO
        $thumbnail = new Image;


        //creating the album
        //TODO
        $album = new Album;


        $event = new Event;
        $event->eventName = $request->eventName;
        $event->pointType = $request->pointType;
        $event->points = $request->points;
        $event->user_id = Auth::user()->id;
        $event->date = $request->date;
        $event->description = $request->description;
        $event->location = $request->location;


        //ADDING SEMESTER_ID
        //TODO

        $event->save();

        return \Redirect::to('/events');
    }
}