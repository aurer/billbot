<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	// Paths allowed without login
	$allowed = array(
		'test',
		'login',
		'user/join',
		'user/reset*',
		'user/thanks',
		'user/confirm*',
		'autoschema*',
	);

	// Login action
	if( Input::get('__username') && Input::get('__password') ){
		if ( !Auth::attempt(array('username' => Input::get('__username'), 'password' => Input::get('__password') ) ) ){
			Session::flash('login-message', 'Sorry that login was not recognised');
			Input::flash('only', array('__username'));
		}
		return Redirect::to( Request::path() );
	}

	// Logout action
	if( Input::get('logout') == 'true' ){
		Auth::logout();
		return Redirect::to( Request::path() );
	}

	// Allow the allowed URLS through
	foreach ($allowed as $uri) {
		if( Request::is($uri) ){
			return;
		}
	}

	// Otherwise check user is logged in
	if ( !Auth::check() ) {
		return View::make('login.index');
	} else {
		Redirect::intended('/');
	}
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


Event::listen('illuminate.query', function($sql, $bindings)
{
    foreach ($bindings as $i => $val) {
        $bindings[$i] = "'$val'";
    }
 
    $sql = str_replace(['?'], $bindings, $sql);
 
    Log::info($sql);
}); 