<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
	$statuses = array(
		400 => 'Bad request',
		401 => 'Unauthorised',
		403 => 'Forbidden',
		404 => 'Not found',
		500 => 'Internal server error',
		503 => 'Service unavailable',
	);
	$messages = array(
		400 => 'The request cannot be fulfilled due to bad syntax.',
		401 => 'Authentication is required and has failed or has not yet been provided.',
		403 => 'You do not have permission to access this resource.',
		404 => 'The page you were looking for could not be found.',
		500 => 'An unexpected condition was encountered.',
		503 => 'The server is currently unavailable because it is overloaded or down for maintenance.',
	);
	return Response::view('errors.error', array(
		'code' => $code,
		'status' => array_key_exists($code, $statuses) ? $statuses[$code] : '',
		'message' => array_key_exists($code, $messages) ? $messages[$code] : '',
		'exception' => $exception,
	), $code);
});

/*
App::missing(function($exception)
{
	return View::make('errors.error')->with( array(
		'exception' => $exception,
		'code' => 404,
	));
});
*/



/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';