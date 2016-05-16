<?php
/*
|--------------------------------------------------------------------------
| OAuth2 Service Account
|--------------------------------------------------------------------------
|
| You can generate client id, service account name and .p12 keyfile from:
| - https://code.google.com/apis/console
|
| For information on how to obtain these keys refer to the README
|
| For information about how it works visit:
| - https://developers.google.com/accounts/docs/OAuth2?hl=it#serviceaccount
| - https://developers.google.com/accounts/docs/OAuth2ServiceAccount
| - https://code.google.com/p/google-api-php-client/wiki/OAuth2#Service_Accounts
|
*/

return array(

	/*
	|--------------------------------------------------------------------------
	| Client ID
	|--------------------------------------------------------------------------
	|
	| Set your client id, it should look like:
	| xxxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com
	|
	*/

	'client_id'        => (Config::get('settings.analytic_client_id') ? Config::get('settings.analytic_client_id') : '291235179580-h15bof9udakbs1fefv4iqr6jjsha8a94.apps.googleusercontent.com'),


	/*
	|--------------------------------------------------------------------------
	| Service Account Name
	|--------------------------------------------------------------------------
	|
	| Set your service account name, it should look like:
	| xxxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@developer.gserviceaccount.com
	|
	*/
	'service_email'    => (Config::get('settings.analytic_service_email') ? Config::get('settings.analytic_service_email') : '291235179580-h15bof9udakbs1fefv4iqr6jjsha8a94@developer.gserviceaccount.com'),


	/*
	|--------------------------------------------------------------------------
	| Path to the .p12 certificate
	|--------------------------------------------------------------------------
	|
	| You need to download this from the Google API Console when the
	| service account was created.
	|
	| Make sure you keep your key.p12 file in a secure location, and isn't
	| readable by others.
	|
	*/

	'certificate_path' => __DIR__ . '/'.(Config::get('settings.analytic_p12_file') ? Config::get('settings.analytic_p12_file') : 'plxh-3a0c7cd03b3e.p12'),


	/*
	|--------------------------------------------------------------------------
	| Returns objects
	|--------------------------------------------------------------------------
	|
	| Returns objects of the Google API Service instead of associative arrays
	|
	*/

	'use_objects'      => true,
);
