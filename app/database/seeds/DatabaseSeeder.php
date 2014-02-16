<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();


    DB::table('entries')->delete();
    DB::table('stations')->delete();
    
		$this->call('StationTableSeeder');
		$this->call('EntryTableSeeder');
	}

}