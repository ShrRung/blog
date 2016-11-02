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
namespace app\houtaiadmin\controller;
use app\houtaiadmin\model\ArticleModel;
use app\houtaiadmin\model\CategorysModel;
use app\houtaiadmin\model\TagModel;
use app\houtaiadmin\model\ArticleTag;
class Article extends Base
{
    public function index(){
        $model_article = new ArticleModel();
        $model_cate = new CategorysModel();
        $model_tag = new TagModel();
        $model_cate_tag = new ArticleTag();
        if(request()->isAjax()){
            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['title'] = ['like', '%' . $param['title'] . '%'];
            }
            if(isset($param['cateId']) && $param['cateId']!=0 ){
                $where['cate_id'] = $param['cateId'];
            }
            if(isset($param['view']) && $param['view']!=2 ){
                $where['view'] = $param['view'];
            }

            $art_list = $model_article->getArticleList($where, $offset, $limit);
            //转换到表格匹配的数据
            foreach($art_list as $key=>$vo){
                $cate = $model_cate->getOneCategory($vo['cate_id']);
                $tags = $model_cate_tag->getTagsByArt($vo['art_id'],1);
                $operate = [
                    '编辑' => url('article/articleEdit', ['art_id' => $vo['art_id']]),
                    '删除' => "javascript:articleDel('".$vo['art_id']."')"
                ];
                $art_list[$key]['operate'] = showOperate($operate);
                $art_list[$key]['cate'] = $cate['title'];
                $art_list[$key]['tags'] = $tags;
                //top
                if($vo['top'] ==1){
                    $art_list[$key]['top'] = '<a class="btn btn-primary btn-sm" id="art_top'.$vo['art_id'].'" href="javascript:change_article_top(1,'.$vo['art_id'].')">是</a>';
                }else{
                    $art_list[$key]['top'] = '<a class="btn btn-primary btn-danger" id="art_top'.$vo['art_id'].'" href="javascript:change_article_top(0,'.$vo['art_id'].')">否</a>';
                }
                //view
                if($vo['view'] ==1){
                    $art_list[$key]['view'] = '<a class="btn btn-primary btn-sm" id="art_view'.$vo['art_id'].'" href="javascript:change_article_view(1,'.$vo['art_id'].')">是</a>';
                }else{
                    $art_list[$key]['view'] = '<a class="btn btn-primary btn-danger" id="art_view'.$vo['art_id'].'" href="javascript:change_article_view(0,'.$vo['art_id'].')">否</a>';
                }

                unset($art_list[$key]['cate_id']);
            }
            $return['total'] = $model_article->getAllArticleCount($where);  //总数据
            $return['rows'] = $art_list;
            $return['art_list'] = $art_list;
            return json($return);
        }
        $cate_list = $model_cate->getAllCategorys();
        $tag_list = $model_tag->getAllTag();
        $this->assign([
            'cate_list' => $cate_list,
            'tag_list' => $tag_list,
            'view' => config('article_view')
        ]);
        return $this->fetch();
    }

    //添加文章
    public function articleAdd()
    {
        $model_article = new ArticleModel();
        $model_cate = new CategorysModel();
        $model_tag = new TagModel();
        if(request()->isPost()){

            $param = input('param.');
            $flag = $model_article->insertArticle($param);
            if($flag['code'] == 1){
                $this->success('添加成功',url('article/index'));
            }else{
                $this->error($flag['msg']);
            }
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }else{
            $cate_list = $model_cate->getAllCategorys();
            $tag_list = $model_tag->getAllTag();
            $this->assign([
                'cate_list' => $cate_list,
                'tag_list' => $tag_list,
                'upload_path' => 'avatar'
            ]);

            return $this->fetch();
        }
    }

    //判断文章是否置顶
    public function changeArtTop(){
        if(request()->isAjax()){
            $model_art = new ArticleModel();
            $param = input('param.');
            $flag = $model_art->changeArtTop($param['art_id'],$param['top']);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }

    //修改文章状态
    public function changeArtView(){
        if(request()->isAjax()){
            $model_art = new ArticleModel();
            $param = input('param.');
            $flag = $model_art->changeArtView($param['art_id'],$param['view']);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }

    /*
     * 删除文章
     */
    public function articleDel(){
        $art_id = input('param.art_id');

        $role = new ArticleModel();
        $flag = $role->articleDel($art_id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    /*
     * 修改文章
     */
    public function articleEdit(){
        $model_art = new ArticleModel();
        $model_cate = new CategorysModel();
        $model_tag = new TagModel();
        $model_article_tag = new ArticleTag();
        if(request()->isPost()){
            $param = input('param.');
            $flag = $model_art->editArticle($param);
            if($flag['code'] == 1){
                $this->success('编辑成功',url('article/index'));
            }else{
                $this->error($flag['msg']);
            }
        }else{
            $cate_list = $model_cate->getAllCategorys();
            $tag_list = $model_tag->getAllTag();
            $art_id = input('param.art_id');
            $art_info = $model_art->getAticle($art_id);
            $art_tag_list = $model_article_tag->getTagsByArt($art_info['art_id'],0);
            $this->assign([
                'cate_list' => $cate_list,
                'tag_list' => $tag_list,
                'art_info' => $art_info,
                'art_tag' => $art_tag_list
            ]);
            return $this->fetch();
        }
    }
}
