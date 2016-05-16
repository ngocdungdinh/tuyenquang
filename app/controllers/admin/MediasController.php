<?php namespace Controllers\Admin;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

use AdminController;
use Input;
use Lang;
use Media;
use Image;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;

class MediasController extends AdminController {

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
            echo $upload['folder'].'/550x500/'.$upload['name'];
        } else {
			echo "Tải ảnh không thành công!";
		}
	}

	public function getUpload() {
		return View::make('backend/medias/upload');
	}

    public function getIndex() {
        // $images = Image::where("created_by", "=", $this->data['user']->id)->order_by('created_at','desc')->get();
        $images = array();
        // Get all the news posts
        $images = Media::orderBy('created_at', 'DESC')->paginate(21);

        return View::make('backend/medias/index', compact('images'));
    }

	public function getMy() {
		// $images = Image::where("created_by", "=", $this->data['user']->id)->order_by('created_at','desc')->get();
		$images = array();
		// Get all the news posts
		$images = Media::where("user_id", Sentry::getId())->orderBy('created_at', 'DESC')->paginate(21);

		return View::make('backend/medias/my', compact('images'));
	}

    public function getDelete($mediaId) {

        if ( !Sentry::getUser()->hasAnyAccess(['medias','medias.delete']) )
            return Redirect::to('admin/notallow');

        // Check if the news post exists
        if (is_null($media = Media::find($mediaId)))
        {
            // Redirect to the news management page
            return Redirect::to('admin/medias')->with('error', Lang::get('admin/medias/message.not_found'));
        }

        // Delete the news post
        $media->delete();

        // Redirect to the news posts management page
        return Redirect::to('admin/medias')->with('success', Lang::get('admin/medias/message.delete.success'));

    }
}