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
	//
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
	// if (Auth::guest()) return Redirect::guest('login');
	if (!Sentry::check()) return Redirect::to('users/login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('admin_auth', function()
{
	if (!Sentry::check())
	{
		// if not logged in, redirect to login
		return Redirect::to('users/login');
	}

	if (!Sentry::getUser()->hasAccess('admin'))
	{
		// has no access
		//return Response::make('Access Forbidden', '403');
		return Redirect::to('/')->with('message', 'You are not authorized to view this.');
	}
});

Route::filter('buyer_auth', function()
{
	if (!Sentry::check())
	{
		// if not logged in, redirect to login
		return Redirect::to('/')->with('message', 'Not logged in!');
	}

	if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('buyers'))
	{
		// has no access
		//return Response::make('Access Forbidden', '403');
		return Redirect::to('/')->with('message', 'You are not authorized to view this.');
	}
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
		//throw new Illuminate\Session\TokenMismatchException;
		return Redirect::back()->with('message', 'Token expired, please try again.');
	}
});