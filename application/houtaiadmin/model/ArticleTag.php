<?php
namespace app\houtaiadmin\model;

use app\houtaiadmin\model\TagModel;
use think\Model;

class ArticleTag extends Model
{
    protected $table = 'cat_article_tag';

    /*
     * 根据文章id获取tag
     * $type 1时，为返回所有title，不然返回所有id
     */
    public function getTagsByArt($art_id,$type){
        $ids = $this->where(['art_id'=>$art_id])->select();
        $model_tag = new TagModel();
        $tags = '';
        foreach($ids as $key=>$val){
            if($type == 1){
                $tag = $model_tag->getOneTag($val['tag_id']);
                if($key == 0){
                    $tags = $tag['title'];
                }else{
                    $tags .= ','.$tag['title'];
                }
            }else{
                $tags[] = $val['tag_id'];
            }

        }
        return $tags;
    }

}