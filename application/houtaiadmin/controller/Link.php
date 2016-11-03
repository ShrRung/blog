<?php
namespace app\houtaiadmin\controller;

use app\houtaiadmin\model\LinkModel;

class Link extends Base{
    //角色列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['author'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $model_link = new LinkModel();
            $selectResult = $model_link->getLinkByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){

                $operate = [
                    '编辑' => url('link/linkEdit', ['link_id' => $vo['link_id']]),
                    '删除' => "javascript:linkDel('".$vo['link_id']."')"
                ];
                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $model_link->getLinkCount($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //添加友链
    public function linkAdd()
    {
        if(request()->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $role = new LinkModel();
            $flag = $role->insertLink($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        $this->assign(['upload_path'=>'link']);
        return $this->fetch();
    }

    //编辑友链
    public function linkEdit()
    {
        $link = new LinkModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $link->editLink($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.link_id');
        $this->assign([
            'link' => $link->getOneLink($id),
            'upload_path' => 'link'
        ]);
        return $this->fetch();
    }

    //删除友链
    public function linkDel()
    {
        $id = input('param.link_id');

        $role = new UserType();
        $flag = $role->delRole($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}