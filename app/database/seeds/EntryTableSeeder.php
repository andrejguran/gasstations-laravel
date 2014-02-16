<?php

class EntryTableSeeder extends Seeder {

    /**
   * Run the database seeds.
   *
   * @return void
   */
    public function run()
    {
        $station_id = DB::table('stations')
                        ->select('id')
                        ->where('cbid', '6596')
                        ->first()
                        ->id;

        Entry::create(array(
          'station_id' => $station_id,
          'fuel' => 'Natural 95',
          'price' => 34.80,
          'added' => '2012-11-20',
        ));

        Entry::create(array(
          'station_id' => $station_id,
          'fuel' => 'Natural 95',
          'price' => 35.50,
          'added' => '2013-08-16',
        ));


    }

}