<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration {

	public function up()
	{
		Schema::create('movies', function(Blueprint $table)
		{
			$table->engine = 'MyISAM';
			
			$table->increments('id');
			$table->string('name'); // From Vegas To Macau
			$table->text('description');
			$table->char('year', 4); // 2015
			$table->string('link'); // from-vegas-to-macau
			$table->string('drive_link');
			$table->string('category'); // anime, action, comedy, http://en.wikipedia.org/wiki/Outline_of_film
			$table->boolean('latest')->default(0);
			$table->boolean('popular')->default(0);
			$table->string('language'); // english, chinese
			$table->timestamps();
		});

		DB::statement('ALTER TABLE movies ADD FULLTEXT search(name)');
	}

	public function down()
	{
		Schema::table('movies', function($table) {
			$table->dropIndex('search');
		});

		Schema::drop('movies');
	}

}
