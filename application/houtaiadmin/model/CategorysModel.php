<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\houtaiadmin\model;

use think\Model;

class CategorysModel extends Model
{
    protected $table = 'cat_categorys';

    /*
     * 获取所有文章分类
     */
    public function getAllCategorys()
    {

        $result = $this->field('cate_id as id,title,pid,level')->where('status', 1)->order('pid,sort')->select();
        $category = subTree($result);

        return $category;
    }

    /*
     * 获取单个分类信息
     * @param id
     */
    public function getOneCategory($id){
        $cate = new CategorysModel();
        $cate_info = $cate::where('cate_id',$id)->find();
        $cate = [
            'id' => $cate_info->cate_id,
            'title' => $cate_info->title,
            'pid' => $cate_info->pid,
            'level' => $cate_info->level,
            'sort' => $cate_info->sort
        ];
        return $cate;
    }

    /*
     * 添加分类
     */
    public function addCategory($cate_info){
        $node = new CategorysModel();
        if($cate_info['pid'] == 0){
            $level = 1;
        }else{
            $pid_cate = $this->getOneCategory($cate_info['pid']);
            $level =  intval($pid_cate['level'])+1;
        }
        try{
            $node::save(['title'=>$cate_info['title'],'pid'=>$cate_info['pid'],'sort'=>$cate_info['sort'],'status'=>1,'level'=>$level
            ]);
            return ['code' => 1, 'data' => '', 'msg' => '添加分类成功'];

        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /*
     * 修改菜单
     */
    public function updateCategory($cate_info){
        $node = new CategorysModel();

        if($cate_info['pid'] == 0){
            $level = 1;
        }else{
            $pid_menu = $this->getOneCategory($cate_info['pid']);
            $level =  intval($pid_menu['level'])+1;
        }
        try{
            $node::save(['title'=>$cate_info['title'],'pid'=>$cate_info['pid'],'sort'=>$cate_info['sort'],'status'=>1,'level'=>$level],
                        ['cate_id'=>$cate_info['cate_id']]);
            return ['code' => 1, 'data' => '', 'msg' => '修改分类成功'];

        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 删除分类
     */
    public function delCategory($cate_id){
        $cate = new CategorysModel();
        try{
            $pids = $cate->where('pid',$cate_id)->select();
            if($pids){
                return ['code' => 0, 'data' => '', 'msg' => '此分类下还有分类，请先删除'];
            }else{
                $cate->where('cate_id', $cate_id)->delete();
                return ['code' => 1, 'data' => '', 'msg' => '删除分类成功'];
            }
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}