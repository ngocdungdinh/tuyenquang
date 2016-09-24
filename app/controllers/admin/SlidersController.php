<?php namespace Controllers\Admin;
/**
 * Created by PhpStorm.
 * User: dungdn-vaio
 * Date: 7/14/2016
 * Time: 3:43 AM
 */
use AdminController;
use Input;
use Lang;
use Post;
use Media;
use Sliders;
use SliderMedia;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;

class SlidersController extends AdminController {
    public function getIndex()
    {
        // Grab all the pages
        $sliderId = 1;
        $slider = Sliders::find($sliderId);
        // Show the page
        return View::make('backend/slider/index', compact('slider'));
    }

    public function postAddImage() {

        $rules = array(
            'media_id' => 'required'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error','Co loi xay ra!');
        }else{
            $media = Media::find(e(Input::get('media_id')));

            $existmedia = SliderMedia::where('slider_id', 1)->where('media_id', $media->id)->first();
            if(is_null($existmedia)) {
                $slidermedia = new SliderMedia;
                $slidermedia->media_id = $media->id;
                $slidermedia->slider_id = 1;
                $slidermedia->save();
                return $media->toJson();
            }

            $media->status = 0;
            return $media->toJson();

        }
    }

    public function postRemoveImage() {

        $rules = array(
            'media_id' => 'required'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error','Co loi xay ra!');
        }else{
            $slidermedia = SliderMedia::where('slider_id', Input::get('slider_id'))->where('media_id', Input::get('media_id'))->first();

            if (!is_null($slidermedia))
            {
                $slidermedia->delete();
                return json_encode(array('status'=> 1, 'media_id' => Input::get('media_id')));
            } else {
                return json_encode('status', 0);
            }
        }
    }
}

