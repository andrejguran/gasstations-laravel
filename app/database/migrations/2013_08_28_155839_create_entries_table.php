<?php

use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entries', function($table)
        {
            $table->increments('id');

            $table->integer('station_id')->unsigned();;
            $table->foreign('station_id')->references('id')->on('stations');
            $table->string('fuel');
            $table->decimal('price');
            $table->date('added');
            
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('entries');
	}

}