<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class ConvertController extends BaseController {

	public function getCategories() {
		// $source_categories = json_decode(file_get_contents('http://localhost/plxh_api/public/api/v1/category'));
		// print_r($source_categories); die();

		// foreach($source_categories->categories as $source_cat) {
		// 	$cat = new Category;
		// 	$cat->id = $source_cat->Cat_ID;
		// 	$cat->name = $source_cat->Cat_Name;
		// 	$cat->slug = $source_cat->Cat_DisplayURL;			
		// 	$cat->parent_id = $source_cat->Cat_ParentID;

		// 	$cat->showon_menu =  $source_cat->Cat_Order;
		// 	if($source_cat->Cat_ParentID < 0)
		// 		$cat->status =  'off';
		// 	else
		// 		$cat->status =  'on';
		// 	$cat->user_id =  1;
		// 	if($cat->save()) {
		// 		echo $cat->id.' - '.$cat->name.'<br />';
		// 	}
		// }
		// print_r($categories);
	}
	
	public function getPosts() {
		
		// die('stop');

		$source_posts = json_decode(file_get_contents('http://pxapi.binhbeer.com:85/api/v1/posts'));

		if($source_posts->error == true) {
			return "Done!";
		}
		foreach($source_posts->posts as $source_post) {
			echo $source_post->News_ID.'<br />';

			$post = new Post;
	        // Update the news post data
	        $post->source_id = $source_post->News_ID;

	        $post->title = $source_post->News_Title;
	        $post->slug = e(Str::slug($post->title));
	        if($source_post->News_Subtitle)
	        	$post->subtitle = $source_post->News_Subtitle;
	        else
	        	$post->subtitle = "";

	        // check slug
	        $existPost = Post::where('source_id', $source_post->News_ID)->first();

	        if (is_null($existPost)) {
		        $post->excerpt = $source_post->News_InitialContent ? $source_post->News_InitialContent : '';
		        $post->content = $source_post->News_Content ? $source_post->News_Content : '';
		        $post->post_note = $source_post->News_ImageNote ? $source_post->News_ImageNote : '';
		        $post->category_id = $source_post->Cat_ID ? $source_post->Cat_ID : 0;

				// $upload = Image::uploadFromUrl('http://img.phapluatxahoi.vn/'.$source_post->News_Image, 'medias', true);
				// die($source_post->News_Image);
		        // process image in post content
		        // echo $post->content; die();
		        $doc = new DOMDocument();
				@$doc->loadHTML($post->content);
				$xpath = new DOMXpath($doc);
				$imgs = $xpath->query("//img");
				for ($i=0; $i < $imgs->length; $i++) {
				    $img = $imgs->item($i);
				    $src = $img->getAttribute("src");
				    // download to Shared Images folder
				    echo $i.' - '.$src;
				    Image::downloadFromUrl($src);
				}
				// die();
				if($source_post->News_Mode == 2) {
					$post->is_featured = 1;
		        	$post->is_popular = 0;
				} else {
					$post->is_featured = 0;
					if(substr_count($post->excerpt, " ") > 10)
		        		$post->is_popular = 1;
		        	else
		        		$post->is_popular = 0;
				}
		        $post->showon_homepage = 1;
		        $post->showon_category = 1;
		        $post->allow_comments = 1;
		        $post->has_picture = 0;
		        $post->has_video = 0;
		        $post->has_audio = 0;
		        $post->post_kind = 0;
		        $post->publish_date = $source_post->News_PublishDate;
		        $post->status = 'published';

		        if($source_post->News_Author) {
		        	$author = User::where('username', $source_post->News_Author)->first();
		        	if(!is_null($author)) {
		        		$post->user_id = $author->id;
		        	} else {
		        		$post->user_id = 1;
		        	}
		        } else {
	        		$post->user_id = 1;
	        	}

		        if($source_post->News_Approver) {
		        	$approver = User::where('username', $source_post->News_Approver)->first();
		        	if(!is_null($approver)) {
		        		$post->user_approve_id = $approver->id;
		        	} else {
		        		$post->user_approve_id = 1;
		        	}
		        } else {
	        		$post->user_approve_id = 1;
	        	}

		        $countTitle = substr_count($post->title, " ");
		        $countContent = $source_post->WordCount ? $source_post->WordCount : 0;
		        $countExcerpt = substr_count($post->excerpt, " ");

		        $array = array('ctitle' => $countTitle, 'ccontent' => $countContent, 'cexcerpt' => $countExcerpt);
		        $post->word_count = json_encode($array);

		        $post->view_count = $source_post->ViewCount ? $source_post->ViewCount : 0;
		        
				// print_r($post); die();
		        if ($post->save()) {
			        // process media
			        // echo 'http://img.phapluatxahoi.vn'.$source_post->News_Image; die();
			        if($source_post->News_Image) {
				    	$upload = Image::uploadFromUrl('http://img.phapluatxahoi.vn/'.$source_post->News_Image, 'medias', true);
				        if($upload){
				            // save to database
				            $media = new Media;
				            $media->mpath = $upload['folder'];
				            $media->mname = $upload['name'];
				            $media->user_id = 1;
				            $media->save();
				            echo $upload['folder'].'/'.Config::get('image.featuredsize').'/'.$upload['name'];
			        		$post->media_id = $media->id;
				        } else {
							echo "Tải ảnh không thành công!";
						}
			        }
			        
			        if($source_post->News_OtherCat) {
			        	$otherCats = explode(',', $source_post->News_OtherCat);
			        	foreach ($otherCats as $value) {
			                $catepost = new CategoryPost;
			                $catepost->category_id = $value;
			                $catepost->post_id = $post->id;
			                if (!$post->category_id)
			                    $post->category_id = $value;
			                $catepost->save();
			        	}
			        	if(!in_array($post->category_id, $otherCats)) {
			                $catepost = new CategoryPost;
			                $catepost->category_id = $post->category_id;
			                $catepost->post_id = $post->id;
			                $catepost->save();
			        	}
			        } else {
		                $catepost = new CategoryPost;
		                $catepost->category_id = $post->category_id;
		                $catepost->post_id = $post->id;
		                $catepost->save();
			        }

			        $post->save();

					$ch = curl_init("http://pxapi.binhbeer.com:85/api/v1/posts");
			        curl_setopt($ch, CURLOPT_HEADER, 0);
			        curl_setopt($ch, CURLOPT_POST, 1);
			        curl_setopt($ch, CURLOPT_POSTFIELDS, array('id'=>$post->source_id));
			        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			        $output = curl_exec($ch);
			        curl_close($ch);
			        echo "<hr />".$output."<hr />";

			    }
			    echo $post->id." - ". $post->title ." - ".$post->slug."<hr />";
			    echo $post->publish_date."<hr />";
			    // print_r($post);
			} else {
				$ch = curl_init("http://pxapi.binhbeer.com:85/api/v1/posts");
		        curl_setopt($ch, CURLOPT_HEADER, 0);
		        curl_setopt($ch, CURLOPT_POST, 1);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, array('id'=>$source_post->News_ID));
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		        $output = curl_exec($ch);
		        curl_close($ch);
		        echo "<hr />".$output."<hr />";				
			}
		}
		unset($source_posts);
        echo '<script type="text/javascript">setTimeout(function() {location.reload();}, 300);</script>';
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
}