<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('stations/', function()
{
    $station = Station::all();

    return $station;
});

Route::get('stations/{id}', function($id)
{
    $station = Station::with('entries')->find($id);

    return $station;
});

Route::get('feed', 'FeedController@feed');
Route::get('stationdata/{cbid}/{fuel?}', 'FeedController@getStationData');
Route::get('feedstation/{cbid}', 'FeedController@feedStation');
Route::get('{fuel}.csv', 'HomeController@csv');
Route::get('delete', 'HomeController@delete');