<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsaRemindersTable extends Migration {

	public function up()
	{
		Schema::create('tsa_reminders', function(Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('tsa_token')->index();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('tsa_reminders');
	}

}
