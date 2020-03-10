<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PassportController extends Controller
{
   	public function postLogin(Request $request)
   	{
   		$this->validate($request,[
   			'email'=>'required|exists:users,email'
   		]);

   		$user = \App\User::where('email',$request->email)->first();
   		$token = $user->createToken("testapp");
   		if(!$user)
   		{
   			return response()->json(['status'=>'false','message'=>'Invalid User name']);
   		}
   		return response()->json(['status'=>'true','user'=>$user,'token'=>$token->accessToken]);
   	}
}
