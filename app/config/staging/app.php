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

	'debug' => true,

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
        'GIOI_THIEU_TINH'	        =>	'7',
        'GIOI_THIEU_CHUNG'	        =>	'24',
        'DU_LICH'	                =>	'25',
        'TIEM_NANG'                 =>	'26',
        'TIN_TUC_SU_KIEN'	        =>	'1',
        'TIN_TRONG_TINH'	        =>	'12',
        'TIN_TRONG_NUOC'	        =>	'13',
        'NGHIEN_CUU_PHAN_TICH'	    =>	'14',
        'LANH_SU_VIET_KIEU'	        =>	'3',
        'LE_TAN_NGOAI_GIAO'	        =>	'18',
        'THU_TUC_HANH_CHINH'	    =>	'19',
        'HOP_TAC_QUOC_TE'	        =>	'2',
        'NGOAI_GIAO_KINH_TE'	    =>	'15',
        'QUAN_HE_VOI_CAC_NUOC'	    =>	'16',
        'NGOAI_GIAO_VAN_HOA'	    =>	'17',
        'DU_AN_FNGO'		        =>	'23',
        'DU_AN_FDI'			        =>	'22',
    ),

);
