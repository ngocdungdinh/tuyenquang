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
use Post;
use Seo;
use Cache;
use Config;
use Royalty;
use Category;
use CategoryPost;
use PostTag;
use TagPost;
use Media;
use DateTime;
use Redirect;
use Permission;
use Sentry;
use Str;
use Validator;
use Activity;
use Request;
use View;
use PostPosition;
use PostVersion;
use FineDiff;
use cURL;
use DB;
// use Diff;

class NewsController extends AdminController
{

    /**
     * Show a list of all the news posts.
     *
     * @return View
     */
    public function getIndex()
    {
        $this->data['curr_time'] = $curr_time = new Datetime();

        $this->data['type'] = $type = Input::get('type', '');
        $this->data['status'] = $status = Input::get('status');
        $this->data['user_id'] = $user_id = Input::get('user_id', 0);
        $this->data['keyword'] = $keyword = Input::get('key');
        $this->data['category_id'] = $category_id = Input::get('category_id', 0);
        $this->data['keyslug'] = $keyslug = Str::slug($keyword);
        // Grab the news posts

        $this->data['appends'] = array(
            'type' => $type,
            'status' => $status,
            'user_id' => $user_id,
            'keyword' => $keyword,
            'category_id' => $category_id,
            'keyslug' => $keyslug
        );

        $this->data['owner_id'] = $this->u->id;

        if ($this->u->hasAnyAccess(['news', 'news.full'])) {
            $this->data['posts'] = Post::filterPosts($this->data)->paginate(30);
        } elseif ($this->u->hasAnyAccess(['news', 'news.editowner'])) {
            $this->data['posts'] = Post::filterPosts($this->data)->where('posts.user_id', '=', $this->u->id)->paginate(30);
        } else {
            $this->data['posts'] = Post::filterPosts($this->data)
                ->where(function ($query) {
                    $query->where('posts.user_id', '=', $this->u->id);
                    $query->where('posts.status', '=', 'draft');
                })
                ->orWhere(function ($query) {
                    $query->where('posts.user_id', '!=', $this->u->id);
                    $query->where('posts.status', '!=', 'draft');
                })->paginate(30);
        }

        $this->data['categories'] = Category::orderBy('showon_menu', 'ASC')->remember(60)->get();
        $this->data['writers'] = Sentry::findAllUsersWithAccess('admin');
        if ($this->u->hasAnyAccess(['news', 'news.editowner'])) {
            $this->data['countposts'] = Post::countposts()->where('posts.user_id', $this->u->id)->first();
        } else {
            $this->data['countposts'] = Post::countposts()->first();
        }
        // Show the page
        return View::make('backend/news/index', $this->data);
    }

    /**
     * Search post.
     *
     * @return View
     */
    public function getSearch()
    {
        // Show the page
        return View::make('backend/news/index', $this->data);
    }

    public function getStatistics()
    {
        $this->data['start_date'] = Input::get('start_date', date("Y-m-d H:i:s", strtotime('first day of this month')));
        $this->data['end_date'] = Input::get('end_date', date("Y-m-d H:i:s", strtotime("now")));

        $this->data['categories'] = Category::orderBy('showon_menu', 'ASC')->get();
        $this->data['writers'] = Sentry::findAllUsersWithAccess('admin');

        $this->data['type'] = $type = Input::get('type', 0);
        $this->data['user_id'] = $user_id = Input::get('user_id', 0);
        $this->data['category_id'] = $category_id = Input::get('category_id', 0);
        // Grab the news posts

        $this->data['appends'] = array(
            'type' => $type,
            'user_id' => $user_id,
            'category_id' => $category_id,
        );

        $this->data['posts'] = $posts = Post::select('*', 'posts.id as id')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('royalties', 'posts.id', '=', 'royalties.item_id')
            ->where('posts.post_type', 'post')
            ->where('posts.status', 'published')
            ->where(function ($query) {
                if ($this->data['category_id'])
                    $query->where('posts.category_id', '=', $this->data['category_id']);
            })
            ->where(function ($query) {
                if ($this->data['user_id'])
                    $query->where('posts.user_id', '=', $this->data['user_id']);
            })
            ->where(function ($query) {
                if ($this->data['type']) {
                    switch ($this->data['type']) {
                        case 'royalty':
                            $query->where('royalties.item_type', 'post');
                            break;
                        case 'notroyalty':
                            $query->whereNull('royalties.id');
                            break;
                    }
                    switch ($this->data['type']) {
                        case 'mostview':
                            $query->orderBy('posts.view_count', 'desc');
                            break;
                    }
                } else {
                    $query->orderBy('posts.created_at', 'DESC');
                }
            })
            ->where('posts.publish_date', '>=', $this->data['start_date'])
            ->where('posts.publish_date', '<=', $this->data['end_date'])
            ->orderBy('posts.created_at', ($this->data['type'] && $this->data['type'] == 'oldest' ? 'asc' : 'desc'))
            ->groupBy('posts.id')
            ->paginate(200);

        $counts = array();
        foreach ($posts as $key => $post) {
            if (!isset($counts['cat'][$post->category_id]['count']))
                $counts['cat'][$post->category_id]['count'] = 0;
            $counts['cat'][$post->category_id]['count'] = $counts['cat'][$post->category_id]['count'] + 1;

            if (!isset($counts['user'][$post->user_id]['count']))
                $counts['user'][$post->user_id]['count'] = 0;
            $counts['user'][$post->user_id]['count'] = $counts['user'][$post->user_id]['count'] + 1;

            # code...
        }
        $this->data['counts'] = $counts;

        return View::make('backend/news/statistics', $this->data);
    }

    /**
     * News post create.
     *
     * @return View
     */
    public function getCreate()
    {
        if (!$this->u->hasAnyAccess(['news', 'news.create']))
            return View::make('backend/notallow');

        $categories = Category::orderBy('showon_menu', 'ASC')->get();
        // Show the page
        return View::make('backend/news/create', compact('categories'));
    }

    /**
     * News post create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {
        if (!$this->u->hasAnyAccess(['news', 'news.create']))
            return View::make('backend/notallow');

        // Declare the rules for the form validation
        $rules = array(
            'title' => 'required|min:3',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Create a new news post
        $post = new Post;

        // Update the news post data
        $post->title = e(Input::get('title'));

        if (Input::get('slug')) {
            $post->slug = $this->slug(Input::get('slug'));
        } else {
            $post->slug = $this->slug(Str::slug(Input::get('title')));
        }

        $post->allow_comments = 1;
        $post->publish_date = new DateTime;
        $post->status = 'draft';

        $post->user_id = $this->u->id;

        //count words
        $countTitle = substr_count(Input::get('title'), " ");
        $countContent = substr_count(strip_tags(Input::get('content')), " ");
        $countExcerpt = substr_count(strip_tags(Input::get('excerpt')), " ");
        $array = array('ctitle' => $countTitle, 'ccontent' => $countContent, 'cexcerpt' => $countExcerpt);
        $post->word_count = json_encode($array);
        // Was the news post created?
        if ($post->save()) {
            // add activities
            Activity::addActivity($this->u->id, $post->id, 'post', 0, 8, $post->title, '/admin/news/' . $post->id . '/edit', '');

            // Redirect to the new news post page
            return Redirect::to("admin/news/$post->id/edit")->with('success', Lang::get('admin/news/message.create.success'));
        }

        // Redirect to the news post create page
        return Redirect::to('admin/news/create')->with('error', Lang::get('admin/news/message.create.error'));
    }

    /**
     * News post update.
     *
     * @param  int $postId
     * @return View
     */
    public function getView($postId = null)
    {
        $this->data['curr_time'] = $curr_time = new Datetime();
        // Check if the news post exists
        if (is_null($post = Post::withTrashed()->with('seo')->find($postId))) {
            // Redirect to the news management page
            return Redirect::to('admin/news')->with('error', Lang::get('admin/news/message.does_not_exist'));
        }

        $this->data['post'] = $post;

        $media = null;
        if ($post->media_id) {
            $media = Media::find($post->media_id);
        }
        $this->data['is_edit'] = true;
        // $this->data['activities'] = Activity::getActivities(0, $post->id)->take(50)->get();

        $this->data['media'] = $media;
        return View::make('backend/news/view', $this->data);
    }
    /**
     * News post update.
     *
     * @param  int $postId
     * @return View
     */
    public function getEdit($postId = null)
    {
        $this->data['curr_time'] = $curr_time = new Datetime();

        // Check if the news post exists
        if (is_null($post = Post::withTrashed()->with('seo')->find($postId))) {
            // Redirect to the news management page
            return Redirect::to('admin/news')->with('error', Lang::get('admin/news/message.does_not_exist'));
        }

        // Get this user permissions
        // $user = Sentry::getUserProvider()->findById($post->user_id);
        $userPermissions = $this->u->getMergedPermissions();
        // print_r($userPermissions); die();
        $this->data['userPermissions'] = $userPermissions;

        if ($post->seo->count() <= 0) {
            $seo = new Seo;
            $seo->updateFromInput();
            $post->seo()->save($seo);
        }

        $this->data['seo'] = isset($post->seo[0]) ? $post->seo[0] : new Seo;
        $this->data['post'] = $post;
        $this->data['categories'] = $categories = Category::orderBy('showon_menu', 'ASC')->get();
        $post_categories = $post->categoryposts()->get();

        $catIds = array();
        foreach ($post_categories as $cat) {
            $catIds[] = $cat->category_id;
        }
        $media = null;
        if ($post->media_id) {
            $media = Media::find($post->media_id);
        }

        $topics = $post->topics;
        $topicIds = array();
        foreach ($topics as $t) {
            $topicIds[] = $t->id;
        }

        $tags = $post->tags;
        $tagIds = array();
        foreach ($tags as $t) {
            $tagIds[] = $t->id;
        }
        // get royalties
        $royalties = Royalty::select('*')
            ->where('item_type', 'post')
            ->where('item_id', $post->id)
            ->get();
        $royalyTotal = Royalty::select('*')
            ->where('item_type', 'post')
            ->where('item_id', $post->id)
            ->sum('total');

        // get relate posts in post
        $relatePostIds = json_decode($post->relate_posts);
        $this->data['relatePosts'] = '';
        if(count($relatePostIds))
            $this->data['relatePosts'] = Post::select('*')->whereIn('id', $relatePostIds)->get();

        $this->data['catIds'] = $catIds;
        $this->data['topicIds'] = $topicIds;
        $this->data['tagIds'] = $tagIds;
        $this->data['media'] = $media;
        $this->data['topics'] = $topics;
        $this->data['tags'] = $tags;
        $this->data['royalties'] = $royalties;
        $this->data['royalyTotal'] = $royalyTotal;

        $this->data['is_edit'] = true;
        // $this->data['activities'] = Activity::getActivities(0, $post->id)->take(50)->get();

        // postversion
        $this->data['postVersions'] = PostVersion::where('post_id', $post->id)->get();

        if (Permission::has_access('news', 'edit') || (Permission::has_access('news', 'editowner', $post->user_id)) || ($post->status == 'published' && Permission::has_access('news', 'publish')) || (Permission::has_access('news', 'edit', $post->user_id)))
            return View::make('backend/news/edit', $this->data);
        else
            return View::make('backend/notallow');
    }

    /**
     * News Post update form processing page.
     *
     * @param  int $postId
     * @return Redirect
     */
    public function postEdit($postId = null)
    {
        // Check if the news post exists
        if (is_null($post = Post::find($postId))) {
            // Redirect to the news management page
            return Redirect::to('admin/news')->with('error', Lang::get('admin/news/message.does_not_exist'));
        }

        if (!Permission::has_access('news', 'edit') && !Permission::has_access('news', 'editowner', $post->user_id))
            return View::make('backend/notallow');

        // Declare the rules for the form validation
        $rules = array(
            'title' => 'required|min:3',
            // 'excerpt' => 'required|min:3',
            // 'content' => 'required|min:3',
            'publish_date' => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Update reference categories
        if (Input::get('categories')) {
            $post->removeCate();
            foreach (Input::get('categories') as $cateId) {
                $catepost = new CategoryPost;
                $catepost->category_id = $cateId;
                $catepost->post_id = $post->id;
                if (empty($post->category_id)) {
                    $post->category_id = $cateId;
                }
                $catepost->save();
            }         
        }
        
        if(!$post->category_id) {
            // Redirect to the news post management page
            return Redirect::back()->withInput()->with('error', Lang::get('admin/news/message.update.not_choose_category'));
        }
        
        $old_status = $post->status;

        // Update the news post data
        $post->title = e(Input::get('title'));

        if (Input::get('slug')) {
            if ((Input::get('slug') != $post->slug))
                $post->slug = $this->slug(Input::get('slug'));
        } else {
            $post->slug = e(Str::slug(Input::get('title')));
        }

        $post->subtitle = Input::get('subtitle');
        $post->excerpt = Input::get('excerpt');
        $post->content = Input::get('content');
        $post->is_featured = e(Input::get('is_featured', 0));
        $post->is_popular = e(Input::get('is_popular', 0));
        $post->showon_homepage = e(Input::get('showon_homepage', 0));
        $post->showon_category = e(Input::get('showon_category', 0));
        $post->allow_comments = e(Input::get('allow_comments', 0));
        $post->has_picture = e(Input::get('has_picture', 0));
        $post->has_video = e(Input::get('has_video', 0));
        $post->has_audio = e(Input::get('has_audio', 0));
        $post->publish_date = e(Input::get('publish_date'));
        $post->media_id = e(Input::get('media_id'));
        $post->status = e(Input::get('status'));

        $post->source_news = e(Input::get('source_news'));

        $post->post_kind = e(Input::get('post_kind'));
        //word count
        $countTitle = substr_count(Input::get('title'), " ");
        $countContent = substr_count(strip_tags(Input::get('content')), " ");
        $countExcerpt = substr_count(strip_tags(Input::get('excerpt')), " ");
        $array = array('ctitle' => $countTitle, 'ccontent' => $countContent, 'cexcerpt' => $countExcerpt);
        $post->word_count = json_encode($array);

        // Was the news post updated?
        if ($post->save()) {
            // // update Seos
            $seo = Seo::find($post->seo[0]->id);
            $seo->updateFromInput();

            // Update reference topics/tags
            $tagIds = Input::get('tagId');

            if ($tagIds) {
                $post->tags()->sync($tagIds);
            }

            // save to post versions
            $postVersion = new PostVersion();
            $currVersion = $postVersion->maxVersion($post->id);
            $currVersion = isset($currVersion) ? $currVersion + 1 : 1;

            $version = str_pad($currVersion, 4, "0", STR_PAD_LEFT);

            $data = array('user_id' => $this->u->id, 'post_id' => $post->id, 'version' => $version, 'title' => $post->title, 'excerpt' => $post->excerpt, 'content' => $post->content, 'publish_date' => $post->publish_date);

            $verId = $postVersion->addItem($data);

            // save cate url
            $cate = Category::find($post->category_id);
            if($cate->parent_id) {
                $pCate = Category::find($cate->parent_id);
                $cateUrl = $pCate->slug.'/'.$cate->slug;
            } else {
                $cateUrl = $cate->slug;
            }

            $post->category_url = $cateUrl;

            if ($post->category_id) {
                $post->save();
            }
            
            if ($old_status != $post->status) {
                switch ($post->status) {
                    case 'published':
                        $act_type_id = 10;
                        // update news to api
                        // if(Config::get('app.updateapi')) {
                            
                        // }
                        break;
                    case 'submitted':
                        $act_type_id = 11;
                        break;
                    case 'reviewed':
                        $act_type_id = 18;
                        break;
                    case 'reviewing':
                        $act_type_id = 15;
                        break;
                    case 'returned':
                        $act_type_id = 12;
                        // $post->delete();
                    case 'unpublish':
                        $act_type_id = 16;
                        $post->delete();
                        break;
                }
            } else {
                $act_type_id = 9;
            }

            // update cache post
            $key = 'route-'.Str::slug($post->url());
            Cache::forget($key);
            // update cache category
            $key = 'route-'.Str::slug('http://'.Request::getHost().'/'.$cate->slug);
            Cache::forget($key);

            // add activities
            Activity::addActivity($this->u->id, $post->id, 'post', 0, $act_type_id, $post->title, '/admin/news/' . $post->id . '/edit', '');

            // Redirect to the new news post page
            return Redirect::to("admin/news/$postId/edit")->with('success', Lang::get('admin/news/message.update.success'));
        }

        // Redirect to the news post management page
        return Redirect::to("admin/news/$postId/edit")->with('error', Lang::get('admin/news/message.update.error'));
    }

    /**
     * Delete the given news post.
     *
     * @param  int $postId
     * @return Redirect
     */
    public function getDelete($postId)
    {
        if (!$this->u->hasAnyAccess(['news', 'news.delete']))
            return View::make('backend/notallow');

        // Check if the news post exists
        if (is_null($post = Post::find($postId))) {
            // Redirect to the news management page
            return Redirect::to('admin/news')->with('error', Lang::get('admin/news/message.not_found'));
        }
        $post->status = 'deleted';
        $post->save();

        // Delete the news post
        $post->delete();

        // add activities
        Activity::addActivity($this->u->id, $post->id, 'post', 0, 13, $post->title, '/admin/news/' . $post->id . '/edit', '');

        // Redirect to the news posts management page
        return Redirect::to('admin/news')->with('success', Lang::get('admin/news/message.delete.success'));
    }

    /**
     * Set cover image.
     *
     * @param  int $postId
     * @param  int $mediaId
     * @return Redirect
     */
    public function postSetCover()
    {

        $rules = array(
            'media_id' => 'required'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails()) {
            Messages::add('error', 'Co loi xay ra!');
        } else {
            $media = Media::find(e(Input::get('media_id')));
            if (!is_null($post = Post::find(e(Input::get('post_id')))) && !is_null($media)) {
                $post->media_id = $media->id;
                $post->save();
                return $media->toJson();
            } else if ($media) {
                return $media->toJson();
            }
        }
    }

    /**
     * Set primary category post.
     *
     * @param  int $postId
     * @param  int $categoryId
     * @return Redirect
     */
    public function postSetCategory()
    {

        $rules = array(
            'category_id' => 'required'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails()) {
            echo 'Co loi xay ra!';
        } else {
            if (!is_null($post = Post::find(e(Input::get('post_id'))))) {
                $post->category_id = Input::get('category_id');
                $post->save();
                echo 1;
            }
        }
    }


    /**
     * get news list to modal.
     *
     * @param  int $postId
     * @param  int $categoryId
     * @return Redirect
     */
    public function getPostList()
    {
        $this->data['tag_id'] = $tag_id = Input::get('tag_id');
        $this->data['post_id'] = $post_id = Input::get('post_id');
        $this->data['type_sort'] = $type_sort = Input::get('type_sort', '');
        $this->data['keyword'] = $keyword = Input::get('keyword');
        $this->data['category_id'] = $category_id = Input::get('category_id');
        $this->data['keyslug'] = $keyslug = Str::slug($keyword);
        // Grab the news posts
        $this->data['pId'] = $pId = array();
        if ($tag_id) {
            $tps = TagPost::where('tag_id', $tag_id)->get();
            foreach ($tps as $key => $tp) {
                $this->data['pId'][] = $tp->post_id;
            }
        }
        $posts = Post::select('*')
            ->where(function ($query) {
                if ($this->data['keyslug']) {
                    $query->where('slug', 'like', '%' . $this->data['keyslug'] . '%');
                }
            })
            ->where(function ($query) {
                if ($this->data['category_id']) {
                    $query->where('category_id', '=', $this->data['category_id']);
                }
            })
            ->where(function ($query) {
                if (count($this->data['pId'])) {
                    $query->whereNotIn('id', $this->data['pId']);
                }
            })
            ->where('post_type', 'post')
            ->where('status', 'published')
            ->orderBy('publish_date', 'DESC')
            ->paginate(10);

        $categories = Category::orderBy('showon_menu', 'ASC')->get();

        // Show the page
        return View::make('backend/news/postlist', compact('posts', 'categories', 'category_id', 'keyword', 'tag_id', 'post_id', 'type_sort'));
    }


    /**
     * Restore a deleted user.
     *
     * @param  int $id
     * @return Redirect
     */
    public function getRestore($postId = null)
    {

        // Check if the news post exists
        if (is_null($post = Post::withTrashed()->find($postId))) {
            // Redirect to the news management page
            return Redirect::to('admin/news')->with('error', Lang::get('admin/news/message.does_not_exist'));
        }
        $post->user_id = $this->u->id;
        $post->status = 'draft';
        $post->save();

        $post->restore();


        // add activities
        Activity::addActivity($this->u->id, $post->id, 'post', 0, 14, $post->title, '/admin/news/' . $post->id . '/edit', '');

        // Redirect to the news management page
        return Redirect::route('update/news', $post->id)->with('success', Lang::get('admin/news/message.restore.success'));
    }


    /**
     * Return unique slug.
     *
     * @return User
     */
    public function slug($slug)
    {
        $existPost = Post::where('slug', $slug)->first();

        if (!is_null($existPost)) {
            return $slug . '-' . time();
        }

        return $slug;
    }

    public function postAddRelatePost()
    {
        $post_id = Input::get('postId', 0);
        $plus = Input::get('plus', 1);
        $curr_post_id = Input::get('currPostId', 0);
        $post = Post::find($curr_post_id);
        if(!is_null($post) && $post_id) {
            if($post->relate_posts)
                $relatePostIds = json_decode($post->relate_posts);
            else
                $relatePostIds = array();
            if($plus) {
                array_push($relatePostIds, $post_id);
            } else {
                // array_diff( $relatePostIds, array($post_id) );
                foreach (array_keys($relatePostIds, $post_id, true) as $key) {
                    unset($relatePostIds[$key]);
                }
            }
            // resave
            if(count($relatePostIds))
                $post->relate_posts = json_encode(array_values($relatePostIds));
            else
                $post->relate_posts = '';
            
            $post->save();

            $relatePosts = Post::select('*')->whereIn('id', $relatePostIds)->get();

            $dataPosts = '';
            foreach ($relatePosts as $p) {
                $dataPosts .=  '<p id="postrelate-'.$p->id.'"><a href="javascript:void(0)" onclick="addRelatePost( '.$curr_post_id.', '.$p->id.', 0)"><span class="glyphicon glyphicon-minus-sign"></span></a> <a href="'.$p->url().'" target="_blank"></a>'.$p->title.'</p>';
            }

            echo $dataPosts;
        }
    }

    public function getAddNote()
    {
        $post_id = Input::get('post_id', 0);
        $status = Input::get('status', 0);

        // Show the page
        return View::make('backend/news/addnote', compact('post_id', 'status'));
    }

    public function postAddNote()
    {
        $post_id = Input::get('postid', 0);
        $content = Input::get('content');
        $status = Input::get('status');

        $act_id = 17; // add note
        if($status) {
            if($status == 'unpublish') {
                $act_id = 16;
            } elseif($status == 'returned') {
                $act_id = 12;
            } 
        }
        if ($post_id && !is_null($post = Post::find($post_id))) {
            // add activities
            $activity = Activity::addActivity($this->u->id, $post->id, 'post', 0, $act_id, $post->title, '/admin/news/' . $post->id . '/edit', $content);

            if($status) {
                $post->status = $status;
                $post->save();
                // Redirect to the new news post page
                return Redirect::to("admin/news/$post_id/edit")->with('success', Lang::get('admin/news/message.update.success'));
            } else {
                return $activity->toJson();
            }
        }
        return Redirect::to("admin/news/$post_id/edit")->with('error', Lang::get('admin/news/message.update.error'));
    }

    public function getDiff()
    {
        $this->data['PostVersion']['postid'] = Input::get('postid');

        $version = new PostVersion();
//        $this['PostVersion']['isPost'] = 0;
        $this->data['versions'] = $version->toList($this->data['PostVersion']['postid']);

        if(Input::get('data') && !is_null(Input::get('data'))) {

            // get last version
            // get last version
            $this->data['PostVersion'] = Input::get('data');

            $version = new PostVersion();
            $this->data['versions'] = $version->toList($this->data['PostVersion']['postid']);

            $this->data['PostVersion']['prev'] = $version->fullVersion($this->data['PostVersion']['prev']);

            $this->data['PostVersion']['next'] = $version->fullVersion($this->data['PostVersion']['next']);

        } else {

            $this->data['PostVersion']['next'] = PostVersion::select('posts_versions.*', 'users.username', 'users.first_name', 'users.last_name')->where('post_id', $this->data['PostVersion']['postid'])->join('users', 'users.id', '=', 'posts_versions.user_id')->orderBy('posts_versions.version', 'desc')->first();

            $this->data['PostVersion']['prev'] = PostVersion::select('posts_versions.*', 'users.username', 'users.first_name', 'users.last_name')->where('post_id', $this->data['PostVersion']['postid'])->join('users', 'users.id', '=', 'posts_versions.user_id')->where('version', '<', $this->data['PostVersion']['next']->version)->orderBy('posts_versions.version', 'desc')->first();

        }

        $this->data['PostVersion']['isPost'] = 1;
        
        $this->data['PostVersion']['next']->title = $this->diffContent($this->data['PostVersion']['prev']->title, $this->data['PostVersion']['next']->title);

        $this->data['PostVersion']['next']->excerpt = $this->diffContent($this->data['PostVersion']['prev']->excerpt, $this->data['PostVersion']['next']->excerpt);

        $this->data['PostVersion']['next']->content = $this->diffContent($this->data['PostVersion']['prev']->content, $this->data['PostVersion']['next']->content);

        return View::make('backend/news/diff', $this->data);
    }

    public function postDiff()
    {
//        die(var_dump($this->data['PostVersion']));
        return View::make('backend/news/diff', $this->data);
    }

    public function getReSorts() {
        $curr_time = new Datetime;
        
        $this->data['type'] = $type = Input::get('type', 'home');

        if($type == 'home' || $type == 'home_populars') {
            $positions = PostPosition::where('type', $type)->delete();
            return Redirect::to('admin/news/sorts?type='.$type);
        }elseif($type == 'category') {
            $this->data['categories'] = $categories = Category::where('status', 'on')->get();

            foreach ($categories as $key => $cat) {
                $this->data['cat'] = $cat->id;

                $positions = PostPosition::where('type', ($type == 'category' ? $type.'_'.$cat->id : $type))->orderBy('position', 'ASC')->get();

                // search post dont exist in position -> remove it -> post new
                $exist_position = array();
                foreach ($positions as $pp) {
                    $exist_position[] = $pp->post_id;
                }

                // print_r($exist_position); die();
                $posts_featured = Post::select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
                ->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
                ->join('users', 'users.id', '=', 'posts.user_id')
                ->where('posts.post_type', 'post')
                ->where('posts.status', 'published')
                ->where(function ($query) {
                    if ($this->data['type'] == 'home')
                        $query->where('posts.is_featured', 1)->where('showon_homepage', 1);
                    elseif ($this->data['type'] == 'home_populars')
                        $query->where('posts.is_popular', 1)->where('showon_homepage', 1);
                    elseif ($this->data['type'] == 'category' && $this->data['cat'] > 0)
                        $query->where('posts.category_id', $this->data['cat'])->where('showon_category', 1)->where('showon_homepage', 1);
                })
                ->where('posts.publish_date', '<=', new Datetime())
                ->orderBy('posts.publish_date', 'DESC')
                ->take(20)->get();

                foreach ($posts_featured as $key => $post) {
                    if(!in_array($post->id, $exist_position)) {
                        $post_position = new PostPosition;
                        $post_position->post_id = $post->id;
                        $post_position->position = $key + 1;
                        $post_position->type = ($type == 'category') ? $type.'_'.$cat->id : $type;
                        $post_position->save();

                        $exist_position[] = $post->id;
                    }
                }
                foreach ($positions as $key => $pp) {
                    if($key > 20)
                        $pp->delete();
                }
            }
        }
        return Redirect::to('admin/news/sorts');
    }

    /**
     * getSorts post.
     *
     * @return View
     */
    public function getSorts()
    {
        $curr_time = new Datetime;
        // Show the page
        $this->data['categories'] = Category::where('parent_id', 0)->orderBy('showon_menu', 'ASC')->get();
        $this->data['type'] = $type = Input::get('type', 'home');
        $this->data['cat'] = $cat = Input::get('cat', 0);

        if(strpos($this->data['type'],'category') !== false) {
            list($type, $cat) = explode('_', $type);
            $this->data['type'] = $type;
            $this->data['cat'] = $cat;
            $this->data['category'] = $category = Category::find($cat);
        }

        $positions = PostPosition::where('type', ($type == 'category' ? $type.'_'.$cat : $type))->orderBy('position', 'ASC')->get();

        // search post dont exist in position -> remove it -> post new
        $exist_position = array();
        foreach ($positions as $pp) {
            $exist_position[] = $pp->post_id;
        }

        // print_r($exist_position); die();
        if($this->data['type'] == 'category') {
            $posts_featured = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
            ->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.post_type', 'post')
            ->where('posts.status', 'published')
            ->where(function ($query) {
                if ($this->data['type'] == 'home')
                    $query->where('posts.is_featured', 1)->where('showon_homepage', 1);
                elseif ($this->data['type'] == 'home_populars')
                    $query->where('posts.is_popular', 1)->where('showon_homepage', 1);
                elseif ($this->data['type'] == 'category' && $this->data['cat'] > 0)
                    $query->where('showon_category', 1)->where('showon_homepage', 1);
            })
            ->where('posts.publish_date', '<=', new Datetime())
            ->orderBy('posts.publish_date', 'DESC')
            ->take(20)->get();
        } else {
            $posts_featured = Post::select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
            ->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.post_type', 'post')
            ->where('posts.status', 'published')
            ->where(function ($query) {
                if ($this->data['type'] == 'home')
                    $query->where('posts.is_featured', 1)->where('showon_homepage', 1);
                elseif ($this->data['type'] == 'home_populars')
                    $query->where('posts.is_popular', 1)->where('showon_homepage', 1);
                elseif ($this->data['type'] == 'category' && $this->data['cat'] > 0)
                    $query->where('posts.category_id', $this->data['cat'])->where('showon_category', 1)->where('showon_homepage', 1);
            })
            ->where('posts.publish_date', '<=', new Datetime())
            ->orderBy('posts.publish_date', 'DESC')
            ->take(20)->get();
        }

        foreach ($posts_featured as $key => $post) {
            if(!in_array($post->id, $exist_position)) {
                $post_position = new PostPosition;
                $post_position->post_id = $post->id;
                $post_position->position = $key + 1;
                $post_position->type = ($type == 'category') ? $type.'_'.$cat : $type;
                $post_position->save();

                $exist_position[] = $post->id;
            }

            foreach ($positions as $key => $pp) {
                if($key > 20)
                    $pp->delete();
            }
        }

        $this->data['posts_position'] = $posts_position = Post::select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
        ->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
        ->join('posts_position', 'posts_position.post_id', '=', 'posts.id')
        ->join('users', 'users.id', '=', 'posts.user_id')
        ->where('posts.post_type', 'post')
        ->where('posts.status', 'published')
        ->where('posts_position.type', $type == 'category' ? $type.'_'.$cat : $type)
        ->orderBy('posts_position.position', 'ASC')
        ->get();
        return View::make('backend/news/sorts', $this->data);
    }

    public function postUpdatePosition()
    {
        $this->data['data_sort'] = $data_sort = Input::get('datasort');
        $this->data['data_type'] = $data_type = Input::get('datatype');
        if($data_sort)
        {
            $sortArr = explode(',', $data_sort);
            if(count($sortArr > 1))
            {
                foreach ($sortArr as $sort) {
                    if(isset($sort[0]) && $sort[0])
                    {
                        list($post_id, $position) = explode(':', $sort);
                        if($post_id)
                        {
                            $post_position = PostPosition::where('post_id', $post_id)->where('type', $data_type)->first();
                            if(is_null($post_position)) {
                                $post_position = new PostPosition;
                            }
                            $post_position->post_id = $post_id;
                            $post_position->position = $position;
                            $post_position->type = $data_type;
                            $post_position->save();
                        }
                    }
                }            
                return 1;
            }
        }
        return 0;
    }

    public function postAddPosition()
    {
        $this->data['post_id'] = $post_id = Input::get('postId');
        $this->data['data_type'] = $data_type = Input::get('type');

        $position = PostPosition::where('post_id', $post_id)->where('type', $data_type)->first();

        if(is_null($position)) {
            $post_position = new PostPosition;
            $post_position->post_id = $post_id;
            $post_position->position = 0;
            $post_position->type = $data_type;
            $post_position->save();
            return 1;
        }
        return 0;
    }

    public function postRemovePosition()
    {
        $this->data['post_id'] = $post_id = Input::get('postId');
        $this->data['data_type'] = $data_type = Input::get('datatype');
        $this->data['featured'] = $featured = Input::get('featured');
        $this->data['popular'] = $popular = Input::get('popular');
        $this->data['oncat'] = $oncat = Input::get('oncat');

        $position = PostPosition::where('post_id', $post_id)->where('type', $data_type)->first();

        if(!is_null($position)) {
            $position->delete();
            $post = Post::find($post_id);

            if($data_type == 'home' && $featured && $post->is_featured)
                $post->is_featured = 0;
            elseif($data_type == 'home_populars' && $popular && $post->is_popular)
                $post->is_popular = 0;
            elseif($oncat && $post->showon_category)
                $post->showon_category = 0;

            $post->save();
            return 1;
        }
        return 0;
    }

    public function diffContent($from_text, $to_text)
    {
        // limit input
        $from_text = substr($from_text, 0, 1024*100);
        $to_text = substr($to_text, 0, 1024*100);

        // ensure input is suitable for diff
        $from_text = mb_convert_encoding($from_text, 'HTML-ENTITIES', 'UTF-8');
        $to_text = mb_convert_encoding($to_text, 'HTML-ENTITIES', 'UTF-8');

        $granularityStacks = array(
            array(
                "\n\r"
            ),
            array(
                ".\n\r"
            ),
            array(
                "\t .\n\r"
            ),
            array(
                ""
            ));
        $diff_opcodes = FineDiff::getDiffOpcodes($from_text, $to_text, $granularityStacks[2]);
        $diff_opcodes_len = strlen($diff_opcodes);

        $rendered_diff = FineDiff::renderDiffToHTMLFromOpcodes($from_text, $diff_opcodes);

        return $rendered_diff;
    }

    function postSyncApi($postId) {

        $url = 'http://api1.channelvn.net/UpdateDataService.ashx';
        $post = Post::find($postId);

        if(!is_null($post) && $post->channel_id && $post->status == 'published') {
            $newId = $post->source_id;
            $channelId = $post->channel_id;
            $isPublish = 1;
            $publishDate = $post->publish_date;
            $note = 'Published';
            $command = 'UpdateNewsPLXH';
            $token = '6ed62fb6be3e304a4c7926a6e48a4a40';
            if($post->status == 'published')
            $url = cURL::buildUrl($url, ['token' => '6ed62fb6be3e304a4c7926a6e48a4a40']);
            $response = cURL::post($url, ['newId' => $newId, 'channelId' => $channelId, 'isPublish' => $isPublish, 'publishDate' => $publishDate, 'note' => $note.' - '.$post->url(), 'command' => $command, 'token' => $token]);

            return json_encode($response->toArray());
        }
    }

    public function getActivities() {
        $perPage = 30;
        $this->data['page'] = $page = e(Input::get('page', 1));
        $this->data['postId'] = $postId = e(Input::get('post_id', 0));

        $this->data['activities'] = Activity::getActivities(0, $postId)->take($perPage)->remember(5)->get();

        // Show the page
        return View::make('backend/inc/activities-box', $this->data);
    }
}
