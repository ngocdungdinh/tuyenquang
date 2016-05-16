<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Post extends Eloquent {

	/**
	 * Indicates if the model should soft delete.
	 *
	 * @var bool
	 */
	protected $softDelete = true;

	public static $data;
	
	/**
	 * Deletes a news post and all the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the comments
		// $this->comments()->delete();

		// Delete reference cates
		// $this->removeCate();

		// Delete reference tags
		// $this->removeTag();
		
		// Delete the news post
		return parent::delete();
	}

	/**
	 * Returns a formatted post content entry, this ensures that
	 * line breaks are returned.
	 *
	 * @return string
	 */
	public function content()
	{
		return $this->content;
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
	

	/**
	 * Return how many comments this post has.
	 *
	 * @return array
	 */
	public function comments()
	{
		return $this->hasMany('Comment')->where('comment_type', 'post');
	}

	/**
	 * Return the URL to the post.
	 *
	 * @return string
	 */
	public function url()
	{
		if($this->category_url) {
			return URL::route('view-post', array($this->category_url, $this->slug.'-'.$this->id));
		} elseif(isset($this->category->slug)) {
			return URL::route('view-post', array($this->category->slug, $this->slug.'-'.$this->id));
		} else {
			return null;
		}
	}
	/**
	 * Return the URL to the post.
	 *
	 * @return string
	 */
	public function surl()
	{
		if(isset($this->category->slug))
			return $this->category->slug.'/'.$this->slug;
		else
			return null;
	}

	public function wc($field)
	{
		if($this->word_count)
		{
			$word_count = json_decode($this->word_count);

			if(isset($word_count->$field))
				return ' - <span style="color: #ff0000">'.$word_count->$field. ' từ</span>';
		}
	}

	/**
	 * Return the post thumbnail image url.
	 *
	 * @return string
	 */
	public function thumbnail()
	{
		# you should save the image url on the database
		# and return that url here.

		return $this->belongsTo('Media', 'media_id');
	}

	public function category() {
		return $this->belongsTo('Category','category_id');
		// return $this->hasMany('CategoryPost','id');
	}

	public function categories() {
		return $this->belongsToMany('Category','category_post','post_id','category_id');
		// return $this->hasMany('CategoryPost','id');
	}

	public function categoryposts() {
		return $this->hasMany('CategoryPost');
		// return $this->hasMany('CategoryPost','id');
	}

	public function removeCate() {
		$this->categoryposts()->delete();
	}

	public function tags() {
		return $this->belongsToMany('Tag','post_tag','post_id','tag_id');
		// return $this->hasMany('CategoryPost','id');
	}

	public function topics() {
		return $this->belongsToMany('Tag','post_tag','post_id','tag_id')->where('tags.type', 'topic')->select('tags.*', 'post_tag.id as ptid', 'tags.id as tid', 'post_tag.type as pttype');
		// return $this->hasMany('CategoryPost','id');
	}

	public function posttags() {
		return $this->hasMany('PostTag');
	}

	public function removeTag() {
		$this->posttags()->delete();
	}

	public function insertTags($tagIds) {
		$tags = explode(",", $tagIds);
		foreach ($tags as $tagId) {
			# code...
			$posttag = new PostTag;
			$posttag->post_id = $this->id;
			$posttag->tag_id = $tagId;
			$posttag->save();
		}
	}

	public function relates($limit = 2)
	{
        $relatePostIds = array(0);

        if($this->relate_posts) {
            $relatePostIds = json_decode($this->relate_posts);
        }

        if(count($relatePostIds)) {
        	$rposts = Post::select('*')->where('posts.status', 'published')->where('posts.publish_date', '<=', new Datetime())->whereIn('id', $relatePostIds)->take($limit)->get();
        	if(!is_null($rposts))
        		return $rposts;
        }
    }

	public static function answers() {
		return Post::select('posts.id', 'posts.user_id', 'posts.title', 'posts.created_at', 'posts.publish_date', 'posts.status')->where('post_type', 'answer')->orderBy('created_at', 'DESC');
	}

	public static function newsposts() {
		return Post::withTrashed()->select('posts.id', 'user_id', 'posts.title', 'posts.created_at', 'publish_date', 'posts.status')->join('users', 'users.id', '=', 'posts.user_id')->where('posts.post_type', 'post');
	}
	

	public static function countposts() {
		return Post::withTrashed()->select(DB::raw("sum(if(status='published',1,0)) as published, sum(if(status='reviewed',1,0)) as reviewed, sum(if(status='reviewing',1,0)) as reviewing, sum(if(status='submitted',1,0)) as submitted, sum(if(status='unpublish',1,0)) as unpublish, sum(if(status='returned',1,0)) as returned, sum(if(status='draft',1,0)) as draft, sum(if(deleted_at!='null',1,0)) as deleteds, count(id) as total"))->where('posts.post_type', 'post');
	}

    public static function filterPosts($data) {

    	self::$data = $data;

        return Post::withTrashed()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype', DB::raw("CONCAT(if(posts.user_id='".self::$data['owner_id']."',1,0)) as owner_id"))
            ->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
            ->where('posts.post_type', 'post')
            ->where(function ($query) {
                if (self::$data['keyslug'])
                    $query->where('posts.slug', 'like', '%' . self::$data['keyslug'] . '%');
            })
            ->where(function ($query) {
                if (self::$data['category_id'])
                    $query->where('posts.category_id', '=', self::$data['category_id']);
            })
            ->where(function ($query) {
                if (self::$data['user_id'])
                    $query->where('posts.user_id', '=', self::$data['user_id']);
            })
            ->where(function ($query) {
                if (self::$data['status'])
                    $query->where('posts.status', '=', self::$data['status']);
            })
            ->where(function ($query) {
                if (self::$data['type']) {
                    switch (self::$data['type']) {
                        case 'homepage':
                            $query->where('posts.showon_homepage', 1);
                            break;
                        case 'featured':
                            $query->where('posts.is_featured', 1);
                            break;
                        case 'popular':
                            $query->where('posts.is_popular', 1);
                            break;
                    }
                } else {
                    $query->orderBy('posts.created_at', 'DESC');
                }
            })
            ->orderBy('posts.publish_date', (self::$data['type'] && self::$data['type'] == 'oldest' ? 'asc' : 'desc'));
    }


    public function activities()
    {
        return $this->hasMany('Activity','item_id')->select('activities.id', 'activities.item_parent_id', 'activities.item_id', 'activities.user_id', 'activities.act_type', 'activities.content', 'users.avatar', 'users.first_name', 'users.last_name', 'users.username', 'activities.created_at')->where('item_type', 'post')->join('users', 'users.id', '=', 'activities.user_id')->orderByRaw('IF(activities.item_parent_id = 0, activities.id, activities.item_parent_id) ASC');
    }

	public function widgets() {
		return $this->belongsToMany('Widget','widgets_refs','item_id','widget_id')->where('type', 'post')->select('widgets_refs.*', 'widgets.name', 'widgets.form', 'widgets_refs.id as wrid')->orderBy('widgets_refs.position', 'asc')->remember(10);
	}

	public function seo() {
	  return $this->morphMany('Seo', 'seoble');
	}

	public function sidebars() {
	  return $this->morphMany('SidebarRef', 'seoble')->join('Sidebar', 'sidebars.id', '=', 'sidebars_refs.seoble_id');
	}
}
