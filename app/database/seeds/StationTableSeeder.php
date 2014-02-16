<?php

class StationTableSeeder extends Seeder {

    /**
   * Run the database seeds.
   *
   * @return void
   */
    public function run()
    {
        Station::create(array(
          'cbid' => 6596,
          'name' => 'Jambo s.r.o.',
          'city' => 'Blučina',
          'address' => 'Cezavy 627',
          'latitude' => 10.10,
          'longtitude' => 20.20,
        ));
    }

}