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
class Article extends Base
{
    public function index(){
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
            $param = parseParams($param['data']);


            $flag = $model_article->insertArticle($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

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
