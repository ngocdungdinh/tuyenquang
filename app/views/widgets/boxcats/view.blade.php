@if($wdata->status == 'open')
<?php
	if(isset($wdata->category_id) && $wdata->category_id) {

		$this->d['wdata'] = $wdata;

		$category = Category::find($wdata->category_id);
		
    	if (isset($this->d['wdata']->sort) && $this->d['wdata']->sort == 'yes') {
    		$this->data['orderBy'] = $orderBy = 'posts_position.position ASC';
    	} else {
        	$this->data['orderBy'] = $orderBy = 'posts.publish_date DESC';
    	}

		if ($wdata->refpost == 'yes') {
			$posts =  $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname', 'medias.title as mtitle', 'users.first_name', 'users.last_name', 'users.username', 'users.avatar')
    				->leftJoin('posts_position', 'posts_position.post_id', '=', 'posts.id')
					->join('users', 'users.id', '=', 'posts.user_id')
					->join('medias', 'medias.id', '=', 'posts.media_id')
					->where('status', 'published')
					->where('post_type', 'post')
		            ->where(function ($query) {
		                if (isset($this->d['wdata']->sort) && $this->d['wdata']->sort == 'yes') {
		                	$query->where('posts_position.type', 'category_'.$this->d['wdata']->category_id);
		                } else {
			                if ($this->d['wdata']->is_featured == 'yes')
			                    $query->where('is_featured', 1);
			                if ($this->d['wdata']->is_popular == 'yes')
			                    $query->where('is_popular', 1);
			                if ($this->d['wdata']->showon_homepage == 'yes')
			                    $query->where('showon_homepage', 1);
			                if ($this->d['wdata']->showon_category == 'yes')
			                    $query->where('showon_category', 1);
		                }

		            })
		            ->orderByRaw($this->data['orderBy'])
		            ->where('posts.publish_date', '<=', new Datetime())
		            ->groupBy('posts.id')
					->take($wdata->limit)->remember(25)->get();
		} else {
			$posts = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname', 'medias.title as mtitle', 'users.first_name', 'users.last_name', 'users.username', 'users.avatar')
					->join('users', 'users.id', '=', 'posts.user_id')
    				->leftJoin('posts_position', 'posts_position.post_id', '=', 'posts.id')
					->join('medias', 'medias.id', '=', 'posts.media_id')					
					->where('posts.category_id', $wdata->category_id)
					->where('posts.status', 'published')
					->where('posts.post_type', 'post')
		            ->where(function ($query) {
		                if ($this->d['wdata']->is_featured == 'yes')
		                    $query->where('posts.is_featured', 1);
		                if ($this->d['wdata']->is_popular == 'yes')
		                    $query->where('posts.is_popular', 1);
		                if ($this->d['wdata']->showon_homepage == 'yes')
		                    $query->where('posts.showon_homepage', 1);
		                if ($this->d['wdata']->showon_category == 'yes')
		                    $query->where('posts.showon_category', 1);
		                
		                if (isset($this->d['wdata']->sort) && $this->d['wdata']->sort == 'yes')
		                	$query->where('posts_position.type', 'category_'.$this->d['wdata']->category_id);
		            })
		            ->orderByRaw($this->data['orderBy'])
		            ->where('posts.publish_date', '<=', new Datetime())
		            ->take($wdata->limit)->remember(25)->get();
		}


	} else {
		return;
	}
?>
	@include('widgets/boxcats/templates/'.$wdata->template)
@endif