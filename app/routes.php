<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group(array('prefix' => 'convert'), function()
{
	# News Management
	Route::group(array('prefix' => 'news'), function()
	{
		Route::get('/categories', 'ConvertController@getCategories');
		Route::get('/posts', 'ConvertController@getPosts');
	});

});

Route::post('api-login',function()
{
    try
    {
        $user = Sentry::authenticate(Input::all(), true);

        $token = hash('sha256',Str::random(10), false);

        $user->api_token = $token;

        $user->save();

        // Ooops.. something went wrong
	    return Response::json(array(
	        	'error' => false,
	        	'message' => 'Đăng nhập thành công!',
	        	'user_info' => array('token' => $token, 'user' => $user->toArray())
	        ),
	        200
	    );
	    
    } catch(Exception $e) {

        // Ooops.. something went wrong
	    return Response::json(array(
	        	'error' => true,
	        	'message' => 'Có lỗi xảy ra! Kiểm tra lại dữ liệu!',
	        ),
	        200
	    );

    }
});

Route::group(array('prefix' => 'api'), function() {

	Route::get('/', function() {
		return "Protected resource!";
	});

	Route::resource('posts', 'Controllers\Api\NewsController');

});  

Route::group(array('prefix' => 'admin'), function()
{
	Route::get('deletecaches', array('as' => 'deletecaches', 'uses' => 'Controllers\Admin\DashboardController@getDeleteCaches'));

	# News Management
	Route::group(array('prefix' => 'news'), function()
	{
		Route::get('/', array('as' => 'news', 'uses' => 'Controllers\Admin\NewsController@getIndex'));

		Route::get('sorts', array('as' => 'sorts', 'uses' => 'Controllers\Admin\NewsController@getSorts'));
		Route::get('resorts', array('as' => 'resorts', 'uses' => 'Controllers\Admin\NewsController@getReSorts'));
		
		Route::get('search', array('as' => 'search/news', 'uses' => 'Controllers\Admin\NewsController@getSearch'));
		Route::get('create', array('as' => 'create/news', 'uses' => 'Controllers\Admin\NewsController@getCreate'));
		Route::get('postlist', array('as' => 'list/news', 'uses' => 'Controllers\Admin\NewsController@getPostList'));	
		Route::post('create', 'Controllers\Admin\NewsController@postCreate');
		Route::post('setcover', 'Controllers\Admin\NewsController@postSetCover');
		Route::post('setcategory', 'Controllers\Admin\NewsController@postSetCategory');
		Route::get('{NewsId}/view', array('as' => 'view/news', 'uses' => 'Controllers\Admin\NewsController@getView'));
		Route::get('{NewsId}/edit', array('as' => 'update/news', 'uses' => 'Controllers\Admin\NewsController@getEdit'));
		Route::post('{NewsId}/edit', 'Controllers\Admin\NewsController@postEdit');
		Route::get('{NewsId}/delete', array('as' => 'delete/news', 'uses' => 'Controllers\Admin\NewsController@getDelete'));
		Route::get('{NewsId}/restore', array('as' => 'restore/news', 'uses' => 'Controllers\Admin\NewsController@getRestore'));

		Route::post('activities', array('as' => 'activities', 'uses' => 'Controllers\Admin\NewsController@getActivities'));

		Route::post('{NewsId}/syncapi', array('as' => 'syncapi/news', 'uses' => 'Controllers\Admin\NewsController@postSyncApi'));

		// add note
		Route::get('addnote', 'Controllers\Admin\NewsController@getAddNote');
		Route::post('addnote', array('as' => 'addnote/news', 'uses' => 'Controllers\Admin\NewsController@postAddNote'));
		
		Route::post('addrelatepost', array('as' => 'addrelatepost/news', 'uses' => 'Controllers\Admin\NewsController@postAddRelatePost'));
		// statistics
		Route::get('statistics', array('as' => 'statistics/news', 'uses' => 'Controllers\Admin\NewsController@getStatistics'));
        Route::get('diff',array('as'=>'diff/news','uses'=>'Controllers\Admin\NewsController@getDiff'));
        Route::post('diff',array('as'=>'diff/news','uses'=>'Controllers\Admin\NewsController@postDiff'));

        Route::post('updatePostPosition',array('as'=>'position/news','uses'=>'Controllers\Admin\NewsController@postUpdatePosition'));
        Route::post('removeposition',array('as'=>'removeposition/news','uses'=>'Controllers\Admin\NewsController@postRemovePosition'));
        Route::post('addposition',array('as'=>'addposition/news','uses'=>'Controllers\Admin\NewsController@postAddPosition'));
	});

	# Royalties
	Route::group(array('prefix' => 'royalties'), function()
	{
		Route::get('/', array('as' => 'royalties', 'uses' => 'Controllers\Admin\RoyaltiesController@getRoyalties'));
		Route::get('form', array('as' => 'form/royalties', 'uses' => 'Controllers\Admin\RoyaltiesController@getRoyaltyForm'));
		Route::post('form', 'Controllers\Admin\RoyaltiesController@postRoyaltyForm');
		Route::get('delete', array('as' => 'delete/royalties', 'uses' => 'Controllers\Admin\RoyaltiesController@getRoyaltyDelete'));
	});

	# Categories Management
	Route::group(array('prefix' => 'categories'), function()
	{
		Route::get('/', array('as' => 'categories', 'uses' => 'Controllers\Admin\CategoriesController@getIndex'));
		Route::get('create', array('as' => 'create/category', 'uses' => 'Controllers\Admin\CategoriesController@getCreate'));
		Route::post('create', 'Controllers\Admin\CategoriesController@postCreate');
		Route::get('{catId}/edit', array('as' => 'update/category', 'uses' => 'Controllers\Admin\CategoriesController@getEdit'));
		Route::post('{catId}/edit', 'Controllers\Admin\CategoriesController@postEdit');
		Route::get('{catId}/delete', array('as' => 'delete/category', 'uses' => 'Controllers\Admin\CategoriesController@getDelete'));
	});

	# Tags Management
	Route::group(array('prefix' => 'tags'), function()
	{
		Route::get('/', array('as' => 'tags', 'uses' => 'Controllers\Admin\TagsController@getIndex'));
		Route::post('/topicinfo/add', array('as' => 'add/taginfo', 'uses' => 'Controllers\Admin\TagsController@postAddTopicInfo'));
		Route::post('/topicinfo/remove/{tpId}', array('as' => 'remove/taginfo', 'uses' => 'Controllers\Admin\TagsController@postRemoveTopicInfo'));
		Route::get('/topicinfo/{tpId}', array('as' => 'view/taginfo', 'uses' => 'Controllers\Admin\TagsController@getTopicInfo'));
		Route::post('/topicinfo/{tpId}', array('as' => 'update/taginfo', 'uses' => 'Controllers\Admin\TagsController@postTopicInfo'));
		Route::get('/listpopup', array('as' => 'list/tag', 'uses' => 'Controllers\Admin\TagsController@getIndexPopup'));
		Route::post('addposts', 'Controllers\Admin\TagsController@postAddPost');
		Route::get('create', array('as' => 'create/tag', 'uses' => 'Controllers\Admin\TagsController@getCreate'));
		Route::post('ajaxcreate', 'Controllers\Admin\TagsController@postCreateTag');
		Route::get('ajaxlist', 'Controllers\Admin\TagsController@getAjaxList');
		Route::get('removepost', array('as' => 'removepost/tag', 'uses' => 'Controllers\Admin\TagsController@removePost'));
		Route::post('create', 'Controllers\Admin\TagsController@postCreate');
		Route::get('{tagId}/edit', array('as' => 'update/tag', 'uses' => 'Controllers\Admin\TagsController@getEdit'));
		Route::post('{tagId}/edit', 'Controllers\Admin\TagsController@postEdit');
		Route::get('{tagId}/delete', array('as' => 'delete/tag', 'uses' => 'Controllers\Admin\TagsController@getDelete'));
	});

	# Pages Management
	Route::group(array('prefix' => 'pages'), function()
	{
		Route::get('/', array('as' => 'pages', 'uses' => 'Controllers\Admin\PagesController@getIndex'));
		Route::get('create', array('as' => 'create/page', 'uses' => 'Controllers\Admin\PagesController@getCreate'));
		Route::post('create', 'Controllers\Admin\PagesController@postCreate');	
		Route::get('{pageId}/edit', array('as' => 'update/page', 'uses' => 'Controllers\Admin\PagesController@getEdit'));
		Route::post('{pageId}/edit', 'Controllers\Admin\PagesController@postEdit');
		Route::get('{pageId}/delete', array('as' => 'delete/page', 'uses' => 'Controllers\Admin\PagesController@getDelete'));
	});

	# Gallery Management
	Route::group(array('prefix' => 'gallery'), function()
	{
		Route::get('/', array('as' => 'gallery', 'uses' => 'Controllers\Admin\GalleryController@getIndex'));
		Route::get('create', array('as' => 'create/gallery', 'uses' => 'Controllers\Admin\GalleryController@getCreate'));
		Route::post('create', 'Controllers\Admin\GalleryController@postCreate');
		Route::get('{pageId}/edit', array('as' => 'update/gallery', 'uses' => 'Controllers\Admin\GalleryController@getEdit'));
		Route::post('{pageId}/edit', 'Controllers\Admin\GalleryController@postEdit');
		Route::get('{pageId}/delete', array('as' => 'delete/gallery', 'uses' => 'Controllers\Admin\GalleryController@getDelete'));
	});

	# Comments Management
	Route::group(array('prefix' => 'comments'), function()
	{
		Route::get('/', array('as' => 'comments', 'uses' => 'Controllers\Admin\CommentsController@getIndex'));
		Route::get('{cmtId}/edit', array('as' => 'update/comment', 'uses' => 'Controllers\Admin\CommentsController@getEdit'));
		Route::post('{cmtId}/edit', 'Controllers\Admin\CommentsController@postEdit');
		Route::post('{cmtId}/approve', 'Controllers\Admin\CommentsController@postApprove');
		Route::get('{cmtId}/delete', array('as' => 'delete/comment', 'uses' => 'Controllers\Admin\CommentsController@getDelete'));
	});

	# Medias Management
	// Route::group(array('prefix' => 'medias'), function()
	// {
	// 	Route::get('/', 'Controllers\Admin\MediasController@getIndex');
	// 	Route::get('upload', array('as' => 'upload/media', 'uses' => 'Controllers\Admin\MediasController@getUpload'));
	// 	Route::post('upload', 'Controllers\Admin\MediasController@postUpload');
	// 	Route::get('my', 'Controllers\Admin\MediasController@getMy');
	// 	Route::get('{mediaId}/delete', array('as' => 'delete/media', 'uses' => 'Controllers\Admin\MediasController@getDelete'));
	// });

	# User Management
	Route::group(array('prefix' => 'users'), function()
	{
		Route::get('/', array('as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex'));
		Route::get('create', array('as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate'));
		Route::post('create', 'Controllers\Admin\UsersController@postCreate');
		Route::get('{userId}/edit', array('as' => 'update/user', 'uses' => 'Controllers\Admin\UsersController@getEdit'));
		Route::post('{userId}/edit', 'Controllers\Admin\UsersController@postEdit');
		Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete'));
		Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore'));
	});

	# Group Management
	Route::group(array('prefix' => 'groups'), function()
	{
		Route::get('/', array('as' => 'groups', 'uses' => 'Controllers\Admin\GroupsController@getIndex'));
		Route::get('create', array('as' => 'create/group', 'uses' => 'Controllers\Admin\GroupsController@getCreate'));
		Route::post('create', 'Controllers\Admin\GroupsController@postCreate');
		Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'Controllers\Admin\GroupsController@getEdit'));
		Route::post('{groupId}/edit', 'Controllers\Admin\GroupsController@postEdit');
		Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'Controllers\Admin\GroupsController@getDelete'));
		Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'Controllers\Admin\GroupsController@getRestore'));
	});

	# News Letters
	Route::group(array('prefix' => 'newsletters'), function()
	{
		Route::get('/', array('as' => 'admin-newsletters', 'uses' => 'Controllers\Admin\NewslettersController@getIndex'));
		Route::post('/', 'Controllers\Admin\NewslettersController@postIndex');
		Route::get('{nId}/delete', 'Controllers\Admin\NewslettersController@getDelete');
		Route::get('{nId}/restore', 'Controllers\Admin\NewslettersController@getRestore');
		Route::get('{nId}/{status}/invalid', 'Controllers\Admin\NewslettersController@getInvalid');
	});
	

	# Settings Management
	Route::group(array('prefix' => 'settings'), function()
	{
		Route::get('/', array('as' => 'settings', 'uses' => 'Controllers\Admin\SettingsController@getIndex'));
		Route::post('/', 'Controllers\Admin\SettingsController@postIndex');

	});

	# Menus Management
	Route::group(array('prefix' => 'menus'), function()
	{
		Route::get('/', array('as' => 'menus', 'uses' => 'Controllers\Admin\MenusController@getIndex'));
		Route::post('/create', array('as' => 'create/menu', 'uses' => 'Controllers\Admin\MenusController@postCreate'));
		Route::get('{mId}/delete', array('as' => 'delete/menu', 'uses' => 'Controllers\Admin\MenusController@getDelete'));
		Route::post('/link/create', array('as' => 'create/link', 'uses' => 'Controllers\Admin\MenusController@postLinkCreate'));
		Route::get('{lId}/link/delete', array('as' => 'delete/link', 'uses' => 'Controllers\Admin\MenusController@getLinkDelete'));
		Route::post('/', 'Controllers\Admin\MenusController@postIndex');
		Route::post('/updateLinksPosition', 'Controllers\Admin\MenusController@updateLinksPosition');
	});

	# Sidebars Management
	Route::group(array('prefix' => 'sidebars'), function()
	{
		Route::get('/', array('as' => 'sidebars', 'uses' => 'Controllers\Admin\SidebarsController@getIndex'));
		Route::get('/ajaxlist', array('as' => 'sidebars/ajaxlist', 'uses' => 'Controllers\Admin\SidebarsController@getAjaxList'));
		Route::post('/addref', array('as' => 'sidebars/addref', 'uses' => 'Controllers\Admin\SidebarsController@addSidebarRef'));

		Route::get('/form', array('as' => 'sidebars/form', 'uses' => 'Controllers\Admin\SidebarsController@getForm'));
		Route::post('/form', array('as' => 'sidebars/update', 'uses' => 'Controllers\Admin\SidebarsController@postForm'));
		Route::get('/removeref/{srid}', array('as' => 'sidebars/removeref', 'uses' => 'Controllers\Admin\SidebarsController@removeSidebarRef'));
	});

	# Widgets Management
	Route::group(array('prefix' => 'widgets'), function()
	{
		Route::get('/', array('as' => 'widgets', 'uses' => 'Controllers\Admin\WidgetsController@getIndex'));
		Route::get('/ajaxlist', array('as' => 'ajax/widgets', 'uses' => 'Controllers\Admin\WidgetsController@getAjaxList'));
		Route::post('/addwidgetref', array('as' => 'addwr/widgets', 'uses' => 'Controllers\Admin\WidgetsController@postAddWidgetRef'));
		Route::post('/updatestatus/{wid}', array('as' => 'updatestatus/widgets', 'uses' => 'Controllers\Admin\WidgetsController@postStatus'));
		Route::get('/updatewidgetref', array('as' => 'getupdatewr/widgets', 'uses' => 'Controllers\Admin\WidgetsController@getUpdateWidgetRef'));
		Route::post('/updatewidgetref', array('as' => 'updatewr/widgets', 'uses' => 'Controllers\Admin\WidgetsController@postUpdateWidgetRef'));
		Route::post('/removewidgetref', array('as' => 'removewr/widgets', 'uses' => 'Controllers\Admin\WidgetsController@postRemoveWidgetRef'));
		Route::post('/updateposition', array('as' => 'position/widgets', 'uses' => 'Controllers\Admin\WidgetsController@postUpdatePosition'));
	});
	
	Route::post('/analytics', array('as' => 'admin/analytics', 'uses' => 'Controllers\Admin\DashboardController@postAnalytics'));

	# Dashboard
	Route::get('/', array('as' => 'admin', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));

});

# Mail Service
Route::get('email_service/process_email_queue', array('as' => 'email-queue', 'uses' => 'MailController@processEmailQueue'));

Route::get('mail/test', 'MailController@getTest');
/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'auth'), function()
{

	# Login
	Route::get('signin', array('as' => 'signin', 'uses' => 'AuthController@getSignin'));
	Route::post('signin', 'AuthController@postSignin');

	# Register
	Route::get('signup', array('as' => 'signup', 'uses' => 'AuthController@getSignup'));
	Route::post('signup', 'AuthController@postSignup');

	# Account Activation
	Route::get('activate/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));

	# Forgot Password
	Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword'));
	Route::post('forgot-password', 'AuthController@postForgotPassword');

	# Forgot Password Confirmation
	Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
	Route::post('forgot-password/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

	# Logout
	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

});

# Login via social
Route::get('oauth/session/facebook', array('as' => 'get-osignin-facebook', 'uses' => 'OauthController@getLoginWithFacebook'));
Route::post('oauth/session/facebook', array('as' => 'osignin-facebook', 'uses' => 'OauthController@getLoginWithFacebook'));
Route::get('oauth/success', array('as' => 'osignin-success', 'uses' => 'OauthController@getSuccess'));
/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'account'), function()
{

	# Account Dashboard
	Route::get('/', array('as' => 'account', 'uses' => 'Controllers\Account\DashboardController@getIndex'));

	# Profile
	Route::get('profile', array('as' => 'profile', 'uses' => 'Controllers\Account\ProfileController@getIndex'));
	Route::post('profile', 'Controllers\Account\ProfileController@postIndex');

	# Profile avatar
	Route::get('avatar', array('as' => 'avatar', 'uses' => 'Controllers\Account\ProfileController@getAvatar'));
	Route::post('avatar', 'Controllers\Account\ProfileController@postAvatar');

	# Change Password
	Route::get('change-password', array('as' => 'change-password', 'uses' => 'Controllers\Account\ChangePasswordController@getIndex'));
	Route::post('change-password', 'Controllers\Account\ChangePasswordController@postIndex');

	# Change Email
	Route::get('change-email', array('as' => 'change-email', 'uses' => 'Controllers\Account\ChangeEmailController@getIndex'));
	Route::post('change-email', 'Controllers\Account\ChangeEmailController@postIndex');

});


Route::group(array('prefix' => 'u'), function()
{
	Route::get('{username}', array('as' => 'userprofile', 'uses' => 'Controllers\Profile\ProfileController@getIndex'))
	->where(array( 'username' => '[A-Za-z0-9\_.]+'));
});

Route::get('profile/messages', array('as' => 'profile-msg', 'uses' => 'Controllers\Profile\MessagesController@getIndex'));
Route::get('profile/messages/{conId}', array('as' => 'profile-con', 'uses' => 'Controllers\Profile\MessagesController@getMessages'))->where(array( 'conId' => '[0-9]+'));

Route::get('profile/messages/compose/{uId}', array('as' => 'profile-compose', 'uses' => 'Controllers\Profile\MessagesController@getCompose'));
Route::post('profile/messages/compose', 'Controllers\Profile\MessagesController@postCompose');

Route::post('user/follow', array('as' => 'userfollow', 'uses' => 'Controllers\Profile\ProfileController@postFollow'))
->where(array( 'username' => '[0-9\_]+'));
Route::post('user/unfollow', array('as' => 'userunfollow', 'uses' => 'Controllers\Profile\ProfileController@postUnFollow'))
->where(array( 'username' => '[0-9\_]+'));

// Activity
Route::get('activity/get', 'Controllers\Profile\ActivityController@getActivity');
Route::post('activity/add', 'Controllers\Profile\ActivityController@postActivity');

// Activity
Route::get('notifications/get', 'NotificationsController@getAjax');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Medias Routes
|--------------------------------------------------------------------------
|
|
*/
Route::get('medias/upload', 'MediasController@getUpload');
Route::post('medias/upload', 'MediasController@postUpload');
Route::get('medias/upload-youtube', 'MediasController@getUploadYoutube');
Route::get('medias/upload-youtube/oauth2-callback', 'MediasController@getUploadYoutube');
Route::get('medias/add-video', 'MediasController@getVideo');
Route::get('medias/get-youtube', 'MediasController@getYoutubeVideo');
Route::post('medias/get-youtube', 'MediasController@postYoutubeVideo');

Route::post('medias/{mediaId}/delete', 'MediasController@postDelete');

Route::get('medias/cropthumb/{mediaId}', 'MediasController@getCrop');
Route::post('medias/cropthumb/{mediaId}', 'MediasController@postCrop');

Route::get('medias/my', 'MediasController@getMy');
Route::get('medias/index', 'MediasController@getIndex');

Route::get('comments/{postId}/list', 'NewsController@getComments');
Route::post('comments/{postId}/add', 'NewsController@postAddComment');
Route::post('comments/{postId}/addvote', 'NewsController@postAddVote');

Route::get('about-us', function()
{
	//
	return View::make('frontend/about-us');
});


Route::get('rss/{slug}.rss', 'RssController@getRss');

Route::get('lien-he', array('as' => 'lien-he', 'uses' => 'ContactUsController@getIndex'));
Route::post('lien-he', 'ContactUsController@postIndex');

Route::get('lien-ket-website', array('as' => 'web-link', 'uses' => 'PagesController@getWebLink'));

Route::post('search', 'HomeController@postSearch');
Route::get('search/{keyword}', array('before' => 'cache', 'after' => 'cache', 'as' => 'get-search', 'uses' => 'HomeController@getSearch'));

Route::get('newsletters', array('as' => 'newsletters', 'uses' => 'NewslettersController@getNewsletter'));
Route::post('newsletters', 'NewslettersController@postNewsletter');

// place
Route::get('places', 'PlacesController@getIndex');
Route::get('place/{slug}', array('as' => 'view-place', 'uses' => 'PlacesController@getView'))
	->where(array( 'slug' => '[A-Za-z0-9\-]+'));
Route::post('places/create', 'PlacesController@postCreate');
Route::get('places/{pId}/update', 'PlacesController@getUpdate');
Route::post('places/{pId}/update', 'PlacesController@postUpdate');

Route::get('page/{pageSlug}', array('as' => 'view-page', 'uses' => 'PagesController@getView'))
	->where(array( 'pageSlug' => '[A-Za-z0-9\-]+'));

Route::get('tags/{tagSlug}', array('before' => 'cache', 'after' => 'cache', 'as' => 'view-tag', 'uses' => 'NewsController@getTag'))
	->where(array( 'tagSlug' => '[A-Za-z0-9\-]+'));

Route::get('news/getmostcomments', 'NewsController@getAjaxMostPostComments');

Route::get('news/getlastestposts', 'NewsController@getAjaxLastestPosts');

Route::get('print/{postSlug}', array('as' => 'print-post', 'uses' => 'NewsController@getPrint'))
	->where(array('postSlug' => '[A-Za-z0-9\-]+'));

Route::get('{catSlug}', array('before' => 'cache', 'after' => 'cache', 'as' => 'view-category', 'uses' => 'NewsController@getCategory'))
	->where(array( 'catSlug' => '[A-Za-z0-9\-]+'));

Route::get('{catSlug}/{postSlug}', array('before' => 'cache', 'after' => 'cache', 'as' => 'view-post', 'uses' => 'NewsController@getView'))
	->where(array('catSlug' => '[A-Za-z0-9\-]+', 'postSlug' => '[A-Za-z0-9\-]+'));

Route::get('{pCatSlug}/{catSlug}/{postSlug}', array('before' => 'cache', 'after' => 'cache', 'as' => 'view-post', 'uses' => 'NewsController@getView'))
	->where(array('pCatSlug' => '[A-Za-z0-9\-]+', 'catSlug' => '[A-Za-z0-9\-]+', 'postSlug' => '[A-Za-z0-9\-]+'));

Route::post('statistic/{postId}/updatepostview', 'NewsController@updatePostView');

Route::get('/', array('before' => 'cache', 'after' => 'cache', 'as' => 'home', 'uses' => 'HomeController@showIndex'));