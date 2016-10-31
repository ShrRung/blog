<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 2016/10/27
 * Time: 17:14
 */
namespace app\houtaiadmin\controller;

use think\Controller;
use app\houtaiadmin\model\Node;

class Menu extends Controller{
    /*
     * menu菜单
     */
    public function index(){
        $node = new Node();
        $menu_list = $node->getAllMenu();

        $this->assign(
            ['menu_list' => $menu_list ]
        );
        return $this->fetch('index');
    }

    /*
     * 添加节点
     */
    public function menuAdd(){
        $node = new Node();
        if(request()->isPost()){
            $param = input('post.');
            $param = parseParams($param['data']);
            $res = $node->addMenu($param);
            return json(['code' => $res['code'], 'data' => $res['data'], 'msg' => $res['msg']]);
        }
        $menu_list = $node->getAllMenu();

        $this->assign(
            ['menu_list' => $menu_list ]
        );
        return $this->fetch();
    }
    /*
     * 编辑节点
     */
    public function menuEdit(){
        $node = new Node();
        if(request()->ispost()){
            $param = input('post.');
            $param = parseParams($param['data']);
            $res = $node->updateMenu($param);
            return json(['code' => $res['code'], 'data' => $res['data'], 'msg' => $res['msg']]);
        }
        $id = input('param.id');
        $menu_info = $node->getOneMenu($id);
        //所有menu
        $menu_list = $node->getAllMenu();
        $this->assign(
            [
                'menu_info' => $menu_info,
                'menu_list' => $menu_list
            ]
        );
        return $this->fetch();
    }

    //删除菜单
    public function MenuDel()
    {
        $id = input('param.id');

        $node = new Node();
        $flag = $node->delMenu($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}