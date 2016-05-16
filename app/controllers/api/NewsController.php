<?php namespace Controllers\Api;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

use BaseController;
use Input;
use Lang;
use Post;
use Seo;
use Cache;
use Config;
use Category;
use CategoryPost;
use PostTag;
use TagPost;
use Media;
use Image;
use DateTime;
use Redirect;
use Permission;
use Sentry;
use Str;
use Validator;
use Activity;
use Request;
use View;
use PostPosition;
use PostVersion;
use DOMDocument;
use DOMXpath;
use FineDiff;
use Response;
// use Diff;

class NewsController extends BaseController
{
	// Edit this:
	public function index()
	{
	    return 'Hello, BBCMS API';
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// title, sapo, content, created_at, image_cover, tags, content_images
		// print_r(Input::all());
		$user = null;

		// Declare the rules for the form validation
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|between:3,32',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
	        // Ooops.. something went wrong
		    return Response::json(array(
		        	'error' => true,
		        	'message' => 'Chưa nhập thông tin hoặc thông tin đăng nhập không hợp lệ',
		        ),
		        200
		    );
		}

	    try
	    {
	        $user = Sentry::authenticate(Input::only('email', 'password'), true);

	        // $token = hash('sha256',Str::random(10), false);

	        // $user->api_token = $token;

	        // $user->save();
		    
	    } catch(Exception $e) {

	        // Ooops.. something went wrong
		    return Response::json(array(
		        	'error' => true,
		        	'message' => 'Đăng nhập không thành công!',
		        ),
		        200
		    );

	    }


        if (is_null($user) || !$user->hasAnyAccess(['news', 'news.create'])) {
		    return Response::json(array(
		        	'error' => true,
		        	'message' => 'Bạn chưa được cấp phép để đăng tin!',
		        ),
		        200
		    );
        }

        // Declare the rules for the form validation
        $rules = array(
            'title' => 'required|min:3',
            'excerpt' => 'required',
            'content' => 'required',
            'channel_id' => 'required',
            'source_id' => 'required',
            'picture' => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
		    return Response::json(array(
		        	'error' => true,
		        	'message' => 'Có lỗi xảy ra! Kiểm tra lại dữ liệu!',
		        ),
		        200
		    );
        }


        // Create a new news post

        // check post
        $post = Post::where('channel_id', Input::get('channel_id'))->where('source_id', Input::get('source_id'))->first();
        if(!is_null($post)) {
        	if($post->status != 'submitted') {
	            // Ooops.. something went wrong
			    return Response::json(array(
			        	'error' => true,
			        	'message' => 'Bài viết không được phép sửa!',
			        ),
			        200
			    );

        	}
        } else {
       		$post = new Post;
        }

        // Update the news post data
        $post->title = e(Input::get('title'));

        $post->slug = Str::slug(Input::get('title'));

        $post->excerpt = Input::get('excerpt');
        $post->content = Input::get('content');
        $post->source_news = Input::get('source_news', 'other');
        $post->channel_id = Input::get('channel_id', 0);
        $post->source_id = Input::get('source_id');
        $post->publish_date = Input::get('publish_date', new DateTime);
        
        $post->category_id = Config::get('app.temp_cat');
        
        $post->status = e(Input::get('status', 'submitted'));

        // upload media
		$upload = Image::uploadFromUrl(Input::get('picture'), 'medias', true);
        if($upload){
            // save to database
            $media = new Media;
            $media->mpath = $upload['folder'];
            $media->mname = $upload['name'];
            $media->user_id = Sentry::getId();
            $media->save();

            $post->media_id = $media->id;
        } else {
		    return Response::json(array(
		        	'error' => true,
		        	'message' => 'Tải ảnh đại diện không thành công!',
		        ),
		        200
		    );
		}

        // download and update image in Content
  //       $doc = new DOMDocument();
		// @$doc->loadHTML($post->content); // important!
		// $xpath = new DOMXpath($doc);
		// $imgs = $xpath->query("//img");
		// // print_r($imgs);
		// if($imgs->length) {
		// 	for ($i=0; $i < $imgs->length; $i++) {
		// 	    $img = $imgs->item($i);
		// 	    $src = $img->getAttribute("src");
		// 	    // download to Shared Images folder
		// 	    // echo $i.' - '.$src.'<hr />';
		// 	    $upload = Image::uploadFromUrl($src, 'medias', true);

		//         if($upload){
		//             // save to database
		//             $media = new Media;
		//             $media->mpath = $upload['folder'];
		//             $media->mname = $upload['name'];
		//             $media->user_id = Sentry::getId();
		//             $media->save();
		//             $newSrc = '/'.$upload['folder'].'/550x500/'.$upload['name'];
		//             $media->newsrc = $newSrc;
		//             // print_r($media);
		//             // /uploads/medias/2014/08/26/550x500/26.08.2014_bb_1409031565.jpg
		//             // $img->setAttribute("src", '/'.$upload['folder'].'/550x500/'.$upload['name']);
		//             $post->content = str_replace($src, $newSrc, $post->content);
		//         } else {
		// 		    $errorMsg[] = 'Ảnh '.$i.' - không tải thành công!';
		// 		}
	 // 			usleep(10000);
		// 	}
		// }
		// print_r($post);
		// die();

        $post->is_featured = e(Input::get('is_featured', 0));
        $post->is_popular = e(Input::get('is_popular', 0));
        $post->showon_homepage = e(Input::get('showon_homepage', 0));
        $post->showon_category = e(Input::get('showon_category', 1));
        $post->allow_comments = e(Input::get('allow_comments', 1));
        $post->has_picture = e(Input::get('has_picture', 0));
        $post->has_video = e(Input::get('has_video', 0));
        $post->has_audio = e(Input::get('has_audio', 0));

        $post->post_kind = e(Input::get('post_kind', 3));

        $post->user_id = $user->id;

        //count words
        $countTitle = substr_count(Input::get('title'), " ");
        $countContent = substr_count(strip_tags(Input::get('content')), " ");
        $countExcerpt = substr_count(strip_tags(Input::get('excerpt')), " ");
        $array = array('ctitle' => $countTitle, 'ccontent' => $countContent, 'cexcerpt' => $countExcerpt);
        $post->word_count = json_encode($array);

        // Was the news post updated?
        if ($post->save()) {
            // save to post versions
            $postVersion = new PostVersion();
            $currVersion = $postVersion->maxVersion($post->id);
            $currVersion = isset($currVersion) ? $currVersion + 1 : 1;

            $version = str_pad($currVersion, 4, "0", STR_PAD_LEFT);

            $data = array('user_id' => $user->id, 'post_id' => $post->id, 'version' => $version, 'title' => $post->title, 'excerpt' => $post->excerpt, 'content' => $post->content);
            if($post->status == 'published') {
                $data['publish_date'] = $post->publish_date;
            }

            $verId = $postVersion->addItem($data);
            
            // save cate url
            $cate = Category::find($post->category_id);
            if($cate->parent_id) {
                $pCate = Category::find($cate->parent_id);
                $cateUrl = $pCate->slug.'/'.$cate->slug;
            } else {
                $cateUrl = $cate->slug;
            }

            $catepost = CategoryPost::where('category_id', $post->category_id)->where('post_id', $post->id)->first();
            if(is_null($catepost)) {
	            $catepost = new CategoryPost;
	            $catepost->category_id = $post->category_id;
	            $catepost->post_id = $post->id;
	            $catepost->save();
            }

            $post->category_url = $cateUrl;

            $post->save();

        	// submitted
            $act_type_id = 11;

            // add activities
            Activity::addActivity($user->id, $post->id, 'post', 0, $act_type_id, $post->title, '/admin/news/' . $post->id . '/edit', '');

		    return Response::json(array(
		        	'error' => false,
		        	'message' => 'Đăng bài viết thành công!',
		        	'id' => $post->id,
		        	'title' => $post->title,
		        	'news_id' => $post->source_id,
		        	'channel_id' => $post->channel_id
		        ),
		        200
		    );
        }

	    return Response::json(array(
	        	'error' => true,
	        	'message' => 'Có lỗi xảy ra!'
	        ),
	        200
	    );
	}
}