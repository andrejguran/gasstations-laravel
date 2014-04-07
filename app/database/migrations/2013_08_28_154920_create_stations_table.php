<?php

use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stations', function($table)
        {
            $table->increments('id');

            $table->integer('cbid')->unique();
            $table->string('name');
            $table->string('city');
            $table->string('address');
            $table->decimal('latitude', 8, 4);
            $table->decimal('longtitude', 8, 4);

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
		Schema::drop('stations');
	}

}