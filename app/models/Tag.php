<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Tag extends Eloquent {
	
	/**
	 * Deletes a news post and all the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the comments
		$this->tagposts()->delete();
		
		// Delete the news post
		return parent::delete();
	}

	public function posts() {
		return $this->belongsToMany('Post','post_tag','tag_id','post_id')->where('posts.status', 'published')->orderBy('posts.publish_date', 'desc');
	}

	public function topicposts() {
		return $this->belongsToMany('Post','tag_post','tag_id','post_id')->where('posts.status', 'published')->orderBy('posts.publish_date', 'desc');
	}

	public function tagposts() {
		return $this->hasMany('TagPost');
	}
}