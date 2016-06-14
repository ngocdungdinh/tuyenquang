<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => false,

	'compress_name' => 'min',
	'js_ver' => '31',
	'css_ver' => '45',
	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => 'http://tuyenquang.dfa.vn',

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => 'Asia/Ho_Chi_Minh',

	'backdays' => 2,

	'temp_cat' => 1083,

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'vi',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => 'aF3b4DNfT96bRA5idf6c7arsiRjb1GhT',

    'homefolder' => array(
        'GIOI_THIEU_TINH'	=>	'7',
        'TIN_TUC_SU_KIEN'	=>	'7',
        'LANH_SU_VIET_KIEU'	=>	'7',
        'HOP_TAC_QUOC_TE'	=>	'7',
        'DU_AN_FNGO'		=>	'7',
        'DU_AN_FDI'			=>	'7',
    ),

);
