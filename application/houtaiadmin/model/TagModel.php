<?php
namespace app\houtaiadmin\model;

use think\Model;

class TagModel extends Model{
    protected $table='cat_tag';
    /*
     * 获取所有tag
     */
    public function getAllTag(){
        $tags = db('tag')->select();
        return $tags;
    }
    /*
     * 获取单个tag
     */
    public function getOneTag($id){
        $tags = db('tag')->where('tag_id',$id)->find();
        return $tags;
    }

    /*
     * 添加tag
     */
    public function insertTag($param){

        try{
            $result =  db('tag')->insert(['title'=>$param['title']]);
            return ['code' => 1, 'data' => '', 'msg' => '添加角色成功'];

        }catch( PDOException $e){

            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 修改标签
     */
    public function updateTag($tag_info){
        $tag = new TagModel();
        try{
            $tag::save(['title'=>$tag_info['title']], ['tag_id'=>$tag_info['tag_id']]);
            return ['code' => 1, 'data' => '', 'msg' => '修改标签成功'];
        }catch(PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 删除标签
     */
    public function tagDel($tag_id){
        $tag = new TagModel();
        try{
            $tag->where('tag_id', $tag_id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除分类成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}