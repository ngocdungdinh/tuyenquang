<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Media extends Eloquent {
	
	/**
	 * Deletes a media and all the files thumb.
	 *
	 * @return bool
	 */
	public function delete()
	{
	    // Get default dimensions
	    $dimensions = Config::get('image.dimensions');
	 
		$targetFilePath = public_path(). '/' .$this->mpath . '/' . $this->mname;
		if(File::exists($targetFilePath)) {
		    foreach ($dimensions as $dimension)
		    {
		        $width   = (int) $dimension[0];
		        $height  = isset($dimension[1]) ?  (int) $dimension[1] : $width;
		    	$crop    = isset($dimension[2]) ? (bool) $dimension[2] : false;
		    	$thumbFilePath = public_path(). '/' .$this->mpath . '/' .$width . 'x' . $height . ($crop ? '_crop' : ''). '/' . $this->mname;
		    	if(File::exists($thumbFilePath))
		    		File::delete($thumbFilePath);
		    }
		    File::delete($targetFilePath);
		}
		// Delete the news post
		return parent::delete();
	}


	/**
	 * Return the post's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

}
