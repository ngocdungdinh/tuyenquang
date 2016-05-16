<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

return array(
    'library'     => 'gd',
    'upload_dir'  => 'uploads',
    'upload_path' => public_path() . '/uploads/',
    'quality'     => 100,
    'bodysize'    => '550x500',
    'featuredsize'    => '500x300_crop',

    'dimensions' => array(
        'thumb'  => array(100, 100, true, 100),
        'thumb1'  => array(140, 80, true, 100),
        'thumb2'  => array(150, 100, true, 100),
        'thumb3'  => array(200, 130, true, 100),
        'thumb4'  => array(220, 140, true, 100),
        'thumb5'  => array(320, 210, true, 100),
        'thumb6' => array(500, 300, true, 100, true),
        'thumb7' => array(550, 500, false, 100, true),
        'medium' => array(670, 360, true, 100, true),
    ),
    'avatar_dimensions' => array(
        'thumb'  => array(30, 30, true, 100),
        'thumb1'  => array(60, 60, true, 100),
        'thumb2'  => array(100, 100, true, 100),
        'thumb3'  => array(200, 240, true, 100)
    ),
);