<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
use App\User;

class Elasticsearch
{
	public static function search($host, $params){
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();

            try{
                return $client->search($params);
            } catch (\Elasticsearch\Common\Exceptions\Missing404Exception $error) {
                return ["hits"=>["hits"=>[],"total"=>0]];
            }
    }
}