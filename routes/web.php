<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/', function (\Illuminate\Http\Request $request) use ($router) {
    $url = "http://lmgtfy.com/?q=";
    $event = $request->json()->all();
    if($event["type"] === "ADDED_TO_SPACE" && $event['space']['type'] == 'ROOM'){
        return ["text" => "Thanks for adding me!"];
    } else if( $event["type"] === "MESSAGE"){
        $query = urlencode(trim(str_replace("@lmgtfybot", "", $event['message']['text'])));
        $response = [];
        $response['sender']['displayName'] = "lmgtfybot";
        $response['sender']['avatarUrl'] = "https://goo.gl/aeDtrS";
        $response['text'] = $url . $query;
        return $response;
    } else if( $event["type"] === "REMOVE_FROM_SPACE" && $event['space']['type'] == 'ROOM' ){
        return ["text" => "Later punks I am outta here!"];
    }
});
