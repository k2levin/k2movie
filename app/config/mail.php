<?php

return array(

	'driver' => 'smtp',

	'host' => 'smtp.gmail.com',

	'port' => 587,

	'from' => array('address' => $_ENV['MAIL_USERNAME'], 'name' => 'k2studio'),

	'encryption' => 'tls',

	'username' => $_ENV['MAIL_USERNAME'],

	'password' => $_ENV['MAIL_PASSWORD'],

	'sendmail' => '/usr/sbin/sendmail -bs',

	'pretend' => false,

);
