<?php
namespace app\houtaiadmin\model;

use think\Model;

class LinkModel extends Model{
    protected $table = 'cat_link';

    public function getLinkByWhere($where, $offset, $limit){
        return $this->where($where)->limit($offset, $limit)->order('create_time desc')->select();
    }

    public function getLinkCount($where){
        return $this->where($where)->count();
    }

    /*
     * 添加友链
     */
    public function insertLink($param){
        try{
            $result =  $this->create(['author'=>$param['author'],'title'=>$param['title'],'url'=>$param['url'],'logo'=>$param['logo'],
                'view'=>1,'sort'=>$param['sort'],'create_time'=>date('Y-m-d h:i:s',time())]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                $model_tag = model('article_tag');
                if(isset($param['tag'])){
                    foreach($param['tag'] as $vo){
                        $model_tag->isUpdate(false)->save(['art_id'=>$result['art_id'],'tag_id'=>$vo]);
                    }
                }
                return ['code' => 1, 'data' => '', 'msg' => '添加文章成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 编辑友链
     */
    public function editLink($param){
        try{
            $result =  $this->save(['author'=>$param['author'],'title'=>$param['title'],'url'=>$param['url'],'logo'=>$param['logo'],
                        'sort'=>$param['sort']],['link_id'=>$param['link_id']]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '修改友链成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 获取单个友链信息
     */
    public function getOneLink($link_id){
        return $this->visible('link_id,author,title,url,logo,sort')->where(['link_id'=>$link_id])->find();
    }

    //删除友链
    public function linkDel($link_id){
        try{
            $result =  $this->where('link_id',$link_id)->delete();
           if($result){
               return ['code' => 1, 'data' => '', 'msg' => '删除成功'];
           }else{
               return ['code' => -1, 'data' => '', 'msg' => '删除失败'];
           }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}