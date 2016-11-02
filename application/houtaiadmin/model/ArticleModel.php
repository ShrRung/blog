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

use app\houtaiadmin\model\TagModel;

class ArticleModel extends Model
{
    protected $table = 'cat_article';

    public function getArticleList($where, $offset, $limit){
        return $this->where($where)->limit($offset, $limit)->order('create_time desc')->select();
    }

    /*
     * 根据条件获取文章列表
     */
    public function getAllArticleCount($where){
        return $this->where($where)->count();
    }

    /*
     * 添加文章
     */
    public function insertArticle($param){
        try{
            $result =  $this->create(['cate_id'=>$param['cate_id'],'title'=>$param['title'],'content'=>htmlspecialchars($param['content']),'abstract'=>$param['abstract'],
                                'sort'=>$param['sort'],'create_time'=>date('Y-m-d h:i:s',time())]);
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
     * 修改文章
     */
    public function editArticle($param){
        try{
            $result =  $this->save(['title'=>$param['title'],'content'=>htmlspecialchars($param['content']),'abstract'=>$param['abstract'],
                'sort'=>$param['sort'],'modify_time'=>date('Y-m-d h:i:s',time())],['art_id'=>$param['art_id']]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                $model_tag = model('article_tag');
                if(isset($param['tag'])){
                    //删除所有
                    $model_tag->where(['art_id'=>$param['art_id']])->delete();
                    //重新添加
                    foreach($param['tag'] as $vo){
                        $model_tag->isUpdate(false)->save(['art_id'=>$param['art_id'],'tag_id'=>$vo]);
                    }
                }
                return ['code' => 1, 'data' => '', 'msg' => '修改文章成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 修改文章状态
     */
    public function changeArtTop($art_id,$top){
        try{
            $result = $this->save(['top'=>$top],['art_id'=>$art_id]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '修改成功'];
            }
        }catch(PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 修改文章显示状态
     */
    public function changeArtView($art_id,$view){
        try{
            $result = $this->save(['view'=>$view],['art_id'=>$art_id]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '修改成功'];
            }
        }catch(PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 删除文章
     * @param $art_id
     */
    public function articleDel($art_id)
    {
        $this->startTrans();
        try{
            // 提交事务
            $this->where('art_id', $art_id)->delete();
            $art_tag = new ArticleTag();
            $art_tag->where('art_id', $art_id)->delete();

            $this::commit();
            return ['code' => 1, 'data' => '', 'msg' => '删除角色成功'];
        } catch (\Exception $e) {
            // 回滚事务
            $this::rollback();
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 获取文章信息
     */
    public function getAticle($art_id){
        return $this->visible(['art_id','cate_id','title','content','abstract','sort'])->where(['art_id'=>$art_id])->find();
    }

}