<?php

$config = new \Phalcon\Config([
	'database' => [
		'host'     => getenv('DATABASE_HOST'),
		'username' => getenv('DATABASE_USER'),
		'password' => getenv('DATABASE_PASS'),
		'dbname'   => getenv('DATABASE_NAME'),
		'charset'  => getenv('DATABASE_CHARSET')
	],
	'redis' => [
		'host'		=> getenv('REDIS_HOST'),
		'port'		=> getenv('REDIS_PORT'),
		'lifetime'	=> getenv('REDIS_LIFETIME')
	],
	'application' => [
		'configDir'			=> APP_DIR . '/config/',
		'controllersDir'	=> APP_DIR . '/controllers/',
		'modelsDir'			=> APP_DIR . '/models/',
		'baseUri'			=> '/',
		'cryptSalt'			=> 'e*A&Sy|:+.u>/6m,$D',
		'version'			=> '1.0.3'
	],
]);