<?php

return array(

	'fetch' => PDO::FETCH_CLASS,

	'default' => 'mysql',

	'connections' => array(
		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => $_ENV['DB_HOST'],
			'database'  => $_ENV['DB_NAME'],
			'username'  => $_ENV['DB_USERNAME'],
			'password'  => $_ENV['DB_PASSWORD'],
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),
	),

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => array(

		'cluster' => false,

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		),

	),

);
