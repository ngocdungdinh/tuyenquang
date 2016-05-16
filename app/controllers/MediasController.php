<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class MediasController extends AuthorizedController {

	public function postUpload() {
        $rules = array(
            'picture' => 'image|max:2500|mimes:jpg,jpeg,png'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
        }

    	$upload = Image::upload(Input::file('picture'), 'medias', true);

        if($upload){

            // save to database
            $media = new Media;
            $media->mpath = $upload['folder'];
            $media->mname = $upload['name'];
            $media->user_id = Sentry::getId();
            $media->save();
            echo $upload['folder'].'/'.Config::get('image.featuredsize').'/'.$upload['name'];
        } else {
			echo "Tải ảnh không thành công!";
		}
	}

    public function getUpload() {
        $env = Input::get('env', 'news');
        return View::make('medias/upload', compact('env'));
    }

    public function getVideo() {
        $env = Input::get('env', 'news');
        return View::make('medias/video', compact('env'));
    }

    public function getYoutubeVideo() {
        // echo Input::get('videourl'); die();
        $env = Input::get('env', 'news');
        // Declare the rules for the form validation
        $rules = array(
            'videourl' => 'required|url'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails())
        {
            // Ooops.. something went wrong
            return json_encode(array('status' => 0));
        }

        $url = Input::get('videourl');

        $pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
        $pattern .= '(?:www\.)?';         #  Optional www subdomain.
        $pattern .= '(?:';                #  Group host alternatives:
        $pattern .=   'youtu\.be/';       #    Either youtu.be,
        $pattern .=   '|youtube\.com';    #    or youtube.com
        $pattern .=   '(?:';              #    Group path alternatives:
        $pattern .=     '/embed/';        #      Either /embed/,
        $pattern .=     '|/v/';           #      or /v/,
        $pattern .=     '|/watch\?v=';    #      or /watch?v=,
        $pattern .=     '|/watch\?.+&v='; #      or /watch?other_param&v=
        $pattern .=   ')';                #    End path alternatives.
        $pattern .= ')';                  #  End host alternatives.
        $pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
        $pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.

        preg_match($pattern, $url, $matches);
        $videoId = (isset($matches[1])) ? $matches[1] : FALSE;

        if($videoId) {
            return json_encode(array('status' => 1, 'videoId' =>$videoId));
        }
    }
    public function postYoutubeVideo() {
        $env = Input::get('env', 'news');
        // Declare the rules for the form validation
        $rules = array(
            'video_id' => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if (!$validator->fails())
        {
            $videoId = Input::get('video_id');
            // save to database
            $video = new Media;
            $video->mpath = 'https://www.youtube.com';
            $video->mname = $videoId;
            $video->mtype = 'video';
            $video->user_id = Sentry::getId();
            $video->save();

            return View::make('medias/video', compact('env', 'video'));
        }
    }

	public function getUploadYoutube() {
        $env = Input::get('env', 'news');
		return View::make('medias/upload_youtube', compact('env'));
	}

    public function postDelete($mediaId) {

        if ( !Sentry::getUser()->hasAnyAccess(['medias','medias.delete']) )
            return Redirect::to('admin/notallow');

        // Check if the news post exists
        if (is_null($media = Media::find($mediaId)))
        {
            return json_encode(array('status'=>0));
        }

        // Delete the news post
        if($media->delete()) {
            return json_encode(array('status'=>1));
        } else {
            return json_encode(array('status'=>0));
        }
    }

    public function getCrop($mediaId) {
        // Check if the news post exists
        if (is_null($media = Media::find($mediaId)))
        {
            return json_encode(array('status'=>0));
        }
        $this->data['media'] = $media;
        
        return View::make('medias/cropthumb', $this->data);
    }

    public function postCrop($mediaId) {
        // Check if the news post exists
        if (is_null($media = Media::find($mediaId)))
        {
            return json_encode(array('status'=>0));
        }

        $this->data['media'] = $media;
        // open source image
        // crop
        $x1 = Input::get('x1');
        $y1 = Input::get('y1');
        $x2 = Input::get('x2');
        $y2 = Input::get('y2');
        $path = $media->mpath . '/' . $media->mname;

        $crop = Image::cropThumb($path, 500, 300, $x1, $y1, $x2, $y2);

        if($crop) {
            return json_encode(array('status' => 1));
        } else {
            return json_encode(array('status' => 0));
        }
    }

    public function getIndex() {
        $env = Input::get('env', 'news');
        $images = array();
        // Get all the news posts
        $images = Media::select('medias.*', 'users.first_name', 'users.last_name', 'users.avatar')
            ->join('users', 'users.id', '=', 'medias.user_id')
            ->orderBy('medias.created_at', 'DESC')->paginate(20);

        return View::make('medias/index', compact('images', 'env'));
    }

	public function getMy() {
        $env = Input::get('env', 'news');
		$images = array();
		// Get all the news posts
		$images = Media::select('medias.*', 'users.first_name', 'users.last_name', 'users.avatar')
            ->join('users', 'users.id', '=', 'medias.user_id')
            ->where("medias.user_id", Sentry::getId())
            ->orderBy('medias.created_at', 'DESC')
            ->paginate(20);

		return View::make('medias/index', compact('images', 'env'));
	}
}