<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Bid;
use DB;
use Mail;

class AdminController extends Controller
{


    function newClassForm(){
    	return view('admin.add_class');
    }

    function newClassSubmit(Request $request){

    	$this->validate($request, [
          'chapter_class' => 'required'
        ]);

    	foreach( $request->roll_number as $key => $val){
    		$token = $this->generateRandomString(128);

    		$bid = new Bid;
    		$bid->email = $request->email[$key];
    		$bid->roll_number = $request->roll_number[$key];
    		$bid->school_class = $request->school_class[$key];
    		$bid->chapter_class = $request->chapter_class;
    		$bid->token = $token;
    		$bid->created_at = date("Y-m-d h:i:s");

    		$bid->save();

    		Mail::send('emails.registration', ["token"=>$token,"class"=>$request->chapter_class], function ($message) use ($request,$key) {
			    $message->from('exec@thetataumiami.com', 'Theta Tau Miami');

			    $message->to($request->email[$key]);
			});
    	}



    	return \Redirect::to('/admin');

    }




    function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
