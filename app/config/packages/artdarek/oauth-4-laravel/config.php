<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => Config::get('app.socialapp.facebook.client_id'),
            'client_secret' => Config::get('app.socialapp.facebook.client_secret'),
            'scope'         => array('email', 'user_birthday', 'user_about_me', 'user_friends', 'user_hometown', 'user_location', 'user_website'),
        ),		

	)

);