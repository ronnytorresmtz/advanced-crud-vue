<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('states', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id');
            $table->string('state_shortname', 4);
            $table->string('state_name', 50);
            $table->softDeletes();
            $table->timestamps();

            $table->index('country_id');
        });


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('states');
	}
}
