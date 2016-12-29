<?php

$config = new \Phalcon\Config([
	'database' => [
		'host'     => getenv('DATABASE_HOST'),
		'username' => getenv('DATABASE_NAME'),
		'password' => getenv('DATABASE_USER'),
		'dbname'   => getenv('DATABASE_PASS'),
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
		'cryptSalt'			=> getenv('CRYPTSALT'),
		'version'			=> getenv('VERSION_NUMBER')
	],
]);