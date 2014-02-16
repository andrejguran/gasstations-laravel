<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function csv($fuel)
	{
		if ($fuel == 'nafta')
			$name = 'Nafta';
		elseif ($fuel == 'natural')
			$name = 'Natural 95';

		$stations = DB::select('SELECT stations.id, stations.cbid, stations.name, stations.city, entries.fuel, entries.price, entries.added FROM stations LEFT JOIN entries ON stations.id = entries.station_id WHERE entries.fuel = ?', array($name));

		return CSV::fromArray($stations)->render();
	}

}