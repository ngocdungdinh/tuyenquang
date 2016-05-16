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

//Cache
Route::filter('cache', function($route, $request, $response = null)
{
    $page = (Paginator::getCurrentPage() > 1 ? Paginator::getCurrentPage() : '');
    $key = 'route-'.Str::slug(Request::url()).$page;
    // echo $key.'<br />';
    // echo Request::getHost(); die();

    if(is_null($response) && Cache::has($key) && App::environment() != 'local' && Config::get('app.debug') != 'true')
    {
        return Cache::get($key);
    } elseif(!is_null($response) && !Cache::has($key) && App::environment() != 'local' && Config::get('app.debug') != 'true') {
        Cache::put($key, $response->getContent(), (Request::is('/') ? 60 : 15));
    }
});

App::before(function($request)
{

	if (!Request::is('auth*') && !Request::is('oauth*') && !Request::is('assets*') && !Request::is('uploads*') && !Request::is('admin*')) {
		$str = Request::path();
		preg_match_all('!\d+!', $str, $matches);
		// print_r($matches);

		//redirect to post
		// if(isset($matches[0][0]) && $matches[0][0]>10000) {
		// 	$pr = Post::where('source_id', $matches[0][0])->first();
		// 	if(!is_null($pr)) {
		// 		return Redirect::to($pr->surl());
		// 	}
		// } elseif(isset($matches[0][0]) && $matches[0][0]<10000) {
		// 	if(isset($matches[0][1]) && $matches[0][1]>0) {
		// 		$cr = Category::find($matches[0][1]);
		// 		if(!is_null($cr)) {
		// 			return Redirect::to($cr->slug);
		// 		}
		// 	}elseif($matches[0][0]>0) {
		// 		$cr = Category::find($matches[0][0]);
		// 		if(!is_null($cr)) {
		// 			return Redirect::to($cr->slug);
		// 		}
		// 	} 
		// 	// return Redirect::route('home');
		// }
	}
	// die();
    // dd(App::environment());
    
	if(Config::get('settings.maintain_mode') == 'yes') {
		if (!Request::is('auth*') && !Request::is('oauth*') && !Request::is('assets*') && !Request::is('uploads*') && !Request::is('admin*')) {
			// die('.');
			return Response::view('frontend/maintenance', array(), 503);
		}
	}

	if ( ! Sentry::check() && !Request::is('auth/*') && !Request::is('oauth*') && !Request::is('medias*') && !Request::is('uploads*') && !Request::is('assets*'))
	{
		// Store the current uri in the session
		Session::put('loginRedirect', Request::url());
	}
});

App::before(function($request, $response)
{
	// print_r($request);
	// die();
});
App::after(function($request, $response)
{
   $response->header('Cache-Control', 'no-cache, max-age=0 ');
   // $response->header('X-Frame-Options', 'ALLOW-ALL');
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

Route::filter('auth.token', function($route, $request)
{

	// Check if the user has access to the admin page
	if ( ! Sentry::check() || ! Sentry::getUser()->hasAccess('admin'))
	{

        $response = Response::json([
            'error' => true,
            'message' => 'Chưa xác thực hoặc không có quyền hạn!',
            'code' => 401],
            401
        );

        $response->header('Content-Type', 'application/json');
    	return $response;
	}

});

Route::filter('auth', function()
{
	// Check if the user is logged in
	if ( ! Sentry::check())
	{
		// Redirect to the login page
		return Redirect::route('signin');
	}
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
| Admin authentication filter.
|--------------------------------------------------------------------------
|
| This filter does the same as the 'auth' filter but it checks if the user
| has 'admin' privileges.
|
*/

Route::filter('admin-auth', function()
{
	// Check if the user is logged in
	if ( ! Sentry::check())
	{
		// Store the current uri in the session
		Session::put('loginRedirect', Request::url());

		// Redirect to the login page
		return Redirect::route('signin');
	}

	// Check if the user has access to the admin page
	if ( ! Sentry::getUser()->hasAccess('admin'))
	{
		// Show the insufficient permissions page
		return App::abort(403);
	}
	
	$user = Sentry::getUser();
	$now = new DateTime();
	$user->last_activity = $now;
	$user->save();
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
    //Session::token() = Input::get('_token');
	if (Session::token() != Input::get('_token') && !Request::is('medias*') && !Request::is('statistic*') && !Request::is('api*') && !Request::is('search*'))
	{
        throw new Illuminate\Session\TokenMismatchException;
	}
});