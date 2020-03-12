<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
use App\User;
use App\Http\Controllers\Elasticsearch;

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


    public function productSearch(Request $request)
    {
        $host = 'localhost:9200'; 
    // DONT USE 'query' variable , its leads to laravel param 
        $query = [
                    "query"=>["match"=>['title'=>$request->q]]
                ];
        $params = [
            'index' => 'product',
            'type' => '_doc',
            'size' => 1000,
            'body' => $query
        ];

        $es = Elasticsearch::search($host,$params);
        if(isset($es['hits']['total']['value']) && $es['hits']['total']['value']!=0)
        {
            return $es['hits']['hits'];
        }   
        else
        {
            return [];
        }

        // lets have some common field in ES 
        // all index can be like "searchable"
        // type can be based on model 
        // have searchable_text field in body which will combine all the search text
        // image field 

        //$processes = search::search($server.":9200", $params)['hits']['hits']);
    }
}
