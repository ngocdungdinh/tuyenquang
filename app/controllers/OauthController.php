<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */


class OauthController extends BaseController {

	public function getLoginWithFacebook()
	{
		// Is the user logged in?
		if (Sentry::check())
		{
			return Redirect::route('account');
		}

	    // get data from input
	    $code = Input::get( 'code' );

	    // get fb service
	    $fb = OAuth::consumer( 'Facebook' );

	    // check if code is valid

	    // if code is provided get user data and sign in
	    if ( !empty( $code ) ) {

	        // This was a callback request from google, get the token
	        $token = $fb->requestAccessToken( $code );
	        // print_r($token); die();
	        // Send a request with it
	        $ouser = json_decode( $fb->request( '/me' ), true );

	        // Array ( [id] => 100004513421116 [name] => Binh Beer [first_name] => Binh [last_name] => Beer [link] => https://www.facebook.com/binhbeervn [username] => binhbeervn [hometown] => Array ( [id] => 106116529418988 [name] => UÃ´ng BÃ­ ) [location] => Array ( [id] => 110931812264243 [name] => Hanoi, Vietnam ) [work] => Array ( [0] => Array ( [employer] => Array ( [id] => 378149008912784 [name] => TÃ¡y mÃ¡y ) [position] => Array ( [id] => 117016058363709 [name] => Big Bird ) [start_date] => 0000-00 ) ) [gender] => male [email] => binhbeer@taymay.vn [timezone] => 7 [locale] => vi_VN [verified] => 1 [updated_time] => 2013-10-23T18:21:15+0000 ) Unable to get friend list.
	        
	        // print_r($ouser); die();
	        // find exist email
	        $user = User::where('email', $ouser['email'])->first();
			// $friendsLists = $fb->request('/me/friends');

			// foreach ($friendsLists as $friends) {
				// foreach ($friends as $friend) {
				// do something with the friend, but you only have id and name
					// print_r($ouser).'<hr />';
				// }
			// }
			// die();

	        if(is_null($user)) {
        		// upload new avatar
        		$ouserAvatarUrl = 'http://graph.facebook.com/'.$ouser['id'].'/picture?width=200&height=200';
    			$upload = Image::uploadUrl($ouserAvatarUrl, 'avatars', true, true);

				try
				{
		        	// Register the user
		        	$birthday = array(0,0,0);
		        	if(isset($ouser['birthday'])) {
		        		$birthday = explode('/', $ouser['birthday']);
		        	}
					$user = Sentry::register(array(
						'username' 	 	=> $ouser['username'],
						'password' 	 	=> $ouser['username'].'1234',
						'first_name' 	=> $ouser['first_name'],
						'last_name' 	=> $ouser['last_name'],
						'hometown' 		=> isset($ouser['hometown']['name']) ? $ouser['hometown']['name'] : '',
						'location' 		=> isset($ouser['location']['name']) ? $ouser['location']['name'] : '',
						'avatar' 		=> $upload['name'],
						'gender' 		=> isset($ouser['gender']) ? $ouser['gender'] : '',
						'email'      	=> $ouser['email'],
						'birth_day'      	=> $birthday[1],
						'birth_month'      	=> $birthday[0],
						'birth_year'      	=> $birthday[2],
						'website'      	=> isset($ouser['website']) ? $ouser['website'] : $ouser['link'],
						'fb_user'      	=> isset($ouser['username']) ? $ouser['username'] : $ouser['id'],
						'fb_id'      	=> $ouser['id'],
						'fb_link'      	=> $ouser['link'],
						'activated'   	=> 1,
					));
			
					// Find the group using the group id
				    $memberGroup = Sentry::findGroupById(4);
				    // Assign the group to the user
				    $user->addGroup($memberGroup);
				}
				catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
					$this->messageBag->add('email', Lang::get('auth/message.account_already_exists'));
				}

				// Redirect to the update password page
				// return Redirect::to('account/update-username')->with('success', Lang::get('auth/message.signin.success'));

	        } else {
	        	$user->fb_user 		= isset($ouser['username']) ? $ouser['username'] : $ouser['id'];
	        	$user->fb_id 		= $ouser['id'];
	        	$user->fb_link 		= $ouser['link'];
	        	$user->activated 	= 1;
	        	
	        	if(!$user->username) {
					$user->username 	= $ouser['username'];
				}

	        	if(!$user->birth_day && isset($ouser['birthday'])) {
		        	$birthday = explode('/', $ouser['birthday']);
					$user->birth_day      	= $birthday[1];
					$user->birth_month      	= $birthday[0];
					$user->birth_year      	= $birthday[2];
				}

	        	if(!$user->gender && $ouser['gender']) {
					$user->gender 	= $ouser['gender'];
				}
	        	
	        	if(!$user->hometown && isset($ouser['hometown']['name'])) {
					$user->hometown  = $ouser['hometown']['name'];
				}

	        	if(!$user->location && isset($ouser['location']['name'])) {
					$user->location  = $ouser['location']['name'];
				}

	        	if(!$user->avatar) {
	        		// upload new avatar
	        		$ouserAvatar = 'http://graph.facebook.com/'.$ouser['id'].'/picture?width=200&height=200';
	    			$upload = Image::uploadUrl(file_get_contents($ouserAvatar), 'avatars', true, true);
					$user->avatar 	= $upload['name'];
				}
				$user->save();
	        }

	        if($user) {
				try
				{
					// Try to log the user in
					Sentry::loginAndRemember($user);

					// Get the page we were before
					$redirect = Session::get('loginRedirect', 'account');

					// Unset the page we were before from the session
					Session::forget('loginRedirect');

					// Redirect to the users page
					return Redirect::to('/')->with('success', Lang::get('auth/message.signin.success'));
				}
				catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
				{
					$this->messageBag->add('email', Lang::get('auth/message.account_not_found'));
				}
				catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
				{
					$this->messageBag->add('email', Lang::get('auth/message.account_not_activated'));
				}
				catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
				{
					$this->messageBag->add('email', Lang::get('auth/message.account_suspended'));
				}
				catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
				{
					$this->messageBag->add('email', Lang::get('auth/message.account_banned'));
				}
	        }

	    }
	    // if not ask for permission first
	    else {
	        // get fb authorization
	        $url = $fb->getAuthorizationUri();

	        // return to facebook login url
	        return Response::make()->header( 'Location', (string)$url );
	    }
	}

}
