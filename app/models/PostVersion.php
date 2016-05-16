<?php
/**
 * Created by PhpStorm.
 * User: dungnt
 * Date: 4/14/14
 * Time: 9:56 PM
 */

class PostVersion extends Eloquent
{
    protected $table = 'posts_versions';

    public function  addItem($data = null, $options = null)
    {
        $row = new PostVersion();
        foreach($data as $key => $value){
            $row->{$key} = $value;
        }
        $row->save();
        return $row->id;
    }

    public function maxVersion($postId){
        $row = $this->where('post_id','=',$postId)->select(DB::raw('max(cast(version as unsigned)) as versions'))->first();
//        return $row['versions;
        return $row->versions;
    }

    public function toList($postId){
        $rows = $this->where('post_id', '=', $postId)->get();
        $tmp = array();
        foreach ($rows as $row) {
            $tmp[$row->id] = $row->version;
        }
        return $tmp;
    }

    public function fullVersion($id){
        return $this->join('users as u','u.id','=','user_id')->where('posts_versions.id','=',$id)
        ->first(array('u.username','u.id','posts_versions.id','title','excerpt','content','posts_versions.created_at'));
    }

}