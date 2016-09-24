<?php
/**
 * Created by PhpStorm.
 * User: dungdn-vaio
 * Date: 7/14/2016
 * Time: 4:37 AM
 */
class Sliders extends Eloquent {
    public function slidermedias() {
        return $this->belongsToMany('Media','slider_media','slider_id','media_id');
    }
}