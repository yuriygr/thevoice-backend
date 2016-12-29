<?php

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new \Phalcon\DI\FactoryDefault();

/**
 * For use in controllers
 */	
$di->set('config', $config);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
	return new \Phalcon\Db\Adapter\Pdo\Mysql([
		'host'		=> $config->database->host,
		'username'	=> $config->database->username,
		'password'	=> $config->database->password,
		'dbname' 	=> $config->database->dbname,
		'charset'	=> $config->database->charset
	]);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
/*$di->set('modelsMetadata', function () use ($config) {
	return new \Phalcon\Mvc\Model\Metadata\Redis([
		'host' 			=> $config->redis->host,
		'port' 			=> $config->redis->port,
		'persistent' 	=> 0,
		'statsKey' 		=> '_PHCM_MM',
		'lifetime' 		=> $config->redis->lifetime
	]);
});*/

/**
 * Request
 */
$di->set('request', function() {
	return new \Phalcon\Http\Request;
});

/**
 * Response
 */
$di->set('response', function() {
	return new \Phalcon\Http\Response;
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function() use ($config) {
	$session = new \Phalcon\Session\Adapter\Redis([
		'host'       => $config->redis->host,
		'port'       => $config->redis->port,
		'lifetime'   => $config->redis->lifetime,
	]);
	$session->start();
	return $session;
});