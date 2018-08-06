<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use DB;

use Image;

class ProfileController extends Controller
{
    public function index(){
        $input = false;
        return view('auth.profile', ['input' => $input], array('user' => Auth::user()) );
    }
    
    public function ativaInput(){
        $input = true;
        return view('auth.profile', ['input' => $input], array('user' => Auth::user()) );
    }
    
    public function update(Request $request){
        $input = false;
        $email = $request->email;
        $users = DB::table('users')->where('cpf', \Auth::user()->cpf)->update(['email' => $email]);
        return redirect()->route('auth.profile');
    }
    
    public function update_avatar(Request $request){
        $input = false;
    	// Handle the user upload of avatar
    	if($request->hasFile('avatar')){
    		$avatar = $request->file('avatar');
    		$filename = time() . '.' . $avatar->getClientOriginalExtension();
    		Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );

    		$user = Auth::user();
    		$user->avatar = $filename;
    		$user->save();
    	}

    	return view('auth.profile', ['input' => $input], array('user' => Auth::user()) );

    }
}
