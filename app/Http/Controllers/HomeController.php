<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
use App\User;
use App\Http\Controller\ElasticSearch;
class HomeController extends Controller
{
    //
    function getDataFromDB($id)
    {
    	$user = User::find($id);
    	return $user;
    }

    public function getUser(Request $request)
    {
    	//127.0.0.1:6379
    	$user = Auth::user();
    	if(env('USE_CACHE'))
    	{
    		if(Cache::has('user_'.$user->id))
    		{
    			$user = Cache::get('user_'.$user->id);
    		}
    		else
    		{
    			$user = Cache::put('user_'.$user->id,$this->getDataFromDB($user->id));
    		}
    	}
    	else
    	{
    		$user = $this->getDataFromDB($user->id);
    	}
    	return response()->json(['status'=>'true','user'=>$user]);
    }


    public function searchUser()
    {
        $params = [
            'index' => 'processes',
            'type' => 'process',
            'size' => 1000,
            // "stored_fields" => ["course_studios"],
            'body' => $query
        ];

        $search = 

        $processes = search::search($server.":9200", $params)['hits']['hits']);
    }
}
