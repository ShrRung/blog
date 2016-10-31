<?php
namespace app\houtaiadmin\controller;

use app\houtaiadmin\model\TagModel;

class Tag extends Base{
    public function index(){
        $tag = new TagModel();
        $tag_list = $tag->getAllTag();

        $this->assign(
            ['tag_list' => $tag_list ]
        );
        return $this->fetch('index');
    }

    /*
     * 添加标签
     */
    public function tagAdd(){
        if(request()->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $role = new TagModel();
            $flag = $role->insertTag($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        return $this->fetch();
    }

    /*
     * 编辑标签
     */
    public function tagEdit(){
        $tag = new TagModel();
        if(request()->ispost()){
            $param = input('post.');
            $param = parseParams($param['data']);
            $res = $tag->updateTag($param);
            return json(['code' => $res['code'], 'data' => $res['data'], 'msg' => $res['msg']]);
        }
        $id = input('param.tag_id');
        $tag_info = $tag->getOneTag($id);
        $this->assign(
            [
                'tag_info' => $tag_info
            ]
        );
        return $this->fetch();
    }

    /*
     * 删除标签
     */
    public function tagDel(){
        $tag_id = input('param.tag_id');

        $node = new TagModel();
        $flag = $node->tagDel($tag_id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}