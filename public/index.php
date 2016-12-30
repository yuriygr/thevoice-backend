<?php

/**
 * Error catch
 */
ini_set('display_errors',1);
error_reporting(E_ALL);

/**
 * Set timezone
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Define App directory
 */
define('BASE_DIR', realpath('../'));
define('APP_DIR', realpath('../app'));
define('PUB_DIR', realpath('../public'));

/**
 * Define App headers
 */
define('APP_HEADERS', [
	'Access-Control-Allow-Origin' 	=> '*',
	'Access-Control-Allow-Methods' 	=> 'POST, GET, PUT',
	'Access-Control-Allow-Headers' 	=> 'Content-Type, X-Auth-Token, Origin, Authorization',
	'Cache-Control' 				=> 'private, max-age=0, must-revalidate',
]);

/**
 * Load vendors from composer
 */
include(BASE_DIR . '/vendor/autoload.php');

/**
 * Read environment 
 */
include(APP_DIR . '/config/environment.php');

/**
 * Read the configuration
 */
include(APP_DIR . '/config/config.php');
	
/**
 * Read auto-loader
 */
include(APP_DIR . '/config/loader.php');

/**
 * Read services
 */
include(APP_DIR . '/config/services.php');

/**
 * Create micro applicateion
 */
$app = new \Phalcon\Mvc\Micro($di);

/**
 * Fuck headers
 */
foreach (APP_HEADERS as $key => $value) {
	$app->response->setHeader($key, $value);
}

/**
 * Requests Collection
 */
$requests = new \Phalcon\Mvc\Micro\Collection();

$requests->setHandler(
    new RequestsController()
);

$requests->setPrefix('/requests');

$requests->get('.getByType', 'getByType');
$requests->post('.addRequest', 'addReuqest');
$requests->post('.addVote', 'addVote');

$app->mount($requests);

/**
 * Catch Throw error
 */
$app->error(function ($e) use ($app) {
	$res = [
		'status' => 'error',
		'massage' => $e->getMessage()
	];
	return $app->response->setJsonContent($res);
});

/**
 * Not found
 */
$app->notFound(function () use ($app) {
	$res = [
		'status' => 'error',
		'massage' => 'This is crazy, but this page was not found!'
	];
	return $app->response->setJsonContent($res);
});

$app->handle();