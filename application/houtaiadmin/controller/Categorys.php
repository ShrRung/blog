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

use app\houtaiadmin\model\CategorysModel;

class Categorys extends Base
{
    public function index(){
        $cate = new CategorysModel();
        $category_list = $cate->getAllCategorys();

        $this->assign(
            ['category_list' => $category_list ]
        );
        return $this->fetch('index');
    }

    /*
     * 添加分类
     */
    public function categoryAdd(){
        $cate = new CategorysModel();
        if(request()->isPost()){
            $param = input('post.');
            $param = parseParams($param['data']);
            $res = $cate->addCategory($param);
            return json(['code' => $res['code'], 'data' => $res['data'], 'msg' => $res['msg']]);
        }
        $cate_list = $cate->getAllCategorys();

        $this->assign(
            ['cate_list' => $cate_list ]
        );
        return $this->fetch();
    }

    /*
     * 修改分类
     */
    public function categoryEdit(){
        $node = new CategorysModel();
        if(request()->ispost()){
            $param = input('post.');
            $param = parseParams($param['data']);
            $res = $node->updateCategory($param);
            return json(['code' => $res['code'], 'data' => $res['data'], 'msg' => $res['msg']]);
        }
        $id = input('param.id');
        $cate_info = $node->getOneCategory($id);
        //所有cate
        $cate_list = $node->getAllCategorys();
        $this->assign(
            [
                'cate_info' => $cate_info,
                'cate_list' => $cate_list
            ]
        );
        return $this->fetch();
    }

    /*
     * 删除分类
     */
    public function categoryDel(){
        $cate_id = input('param.cate_id');

        $node = new CategorysModel();
        $flag = $node->delCategory($cate_id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}