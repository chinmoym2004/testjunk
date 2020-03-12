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
    public static function count($host, $params){
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();

            try{
                return $client->count($params);
            } catch (\Elasticsearch\Common\Exceptions\Missing404Exception $error) {
                return ["count"=>0];
            }
    }

    public static function exists($host,$params){
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        // $client = new \Elasticsearch\Client(); 
        $client =  \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();
        return $client->indices()->exists($params);
    }

    public static function index($host, $params){
        
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();

            return $client->index($params);

            // try{
            //     return $client->index($params);
            // } catch (\Exception $error) {
            //     return ["hits"=>["hits"=>[]]];
            // }
    }

    public static function update($host, $params){
        
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();


            return $client->update($params);

    }
    public static function updateByQuery($host, $params){
        
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();


            return $client->updateByQuery($params);

    }
    public static function get($host, $params){
        
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();

            try{
                return $client->get($params);
            } catch (\Elasticsearch\Common\Exceptions\Missing404Exception $error) {
                return ['_source'=>[]];
            }

    }

    public static function stats($host){
        
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();


            return $client->nodes()->stats();

    }

    public static function create($host, $params){
        
        //$params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();


        return $client->indices()->create($params);

    }
    public static function delete($host, $params){
        
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();


            return $client->indices()->delete($params);

    }
    public static function deletedocument($host, $params){
        
        $params['index']=strtolower(env('APP_NAME',''))."_".$params['index'];
        $client = \Elasticsearch\ClientBuilder::create()
            ->setHosts([$host])
            ->setRetries(0)
            ->build();


            return $client->delete($params);

    } 
}