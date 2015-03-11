<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {

	public function up()
	{
		Schema::create('countries', function($table)
		{
			$table->increments('id');
			$table->string('name');
		});

		Schema::table('users', function($table)
		{
			$table->integer('country_id')->unsigned()->after('name');
		});

		Schema::table('users', function($table)
		{
			$table->foreign('country_id')->references('id')->on('countries');
		});
	}

	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropForeign('users_country_id_foreign');
		});

		Schema::drop('countries');
	}

}
