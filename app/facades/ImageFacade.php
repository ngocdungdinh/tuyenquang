<?php namespace App\Facades;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */
 
use Illuminate\Support\Facades\Facade;
 
class ImageFacade extends Facade {
 
    protected static function getFacadeAccessor()
    {
        return new \App\Services\Image;
    }
 
}