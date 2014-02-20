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

		$stations = DB::select('SELECT stations.id, stations.name, stations.region, stations.city, entries.fuel, entries.price, entries.added FROM stations LEFT JOIN entries ON stations.id = entries.station_id WHERE entries.fuel = ?', array($name));

		return CSV::fromArray($stations)->render();
	}

	public function delete()
	{
		$stations = DB::select('SELECT id, name, COUNT(*) as c FROM stations
								GROUP BY name
								HAVING c < 7
								ORDER BY c');
		$i = 0;
		foreach ($stations as $station)
		{
				DB::delete('delete from entries WHERE station_id = ?', array($station->id));
				DB::delete('delete from stations WHERE id = ?', array($station->id));
		}
		echo $i;
	}

}