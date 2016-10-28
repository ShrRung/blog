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
namespace app\admin\model;

use think\Model;

class Node extends Model
{

    protected $table = "cat_node";

    /**
     * 获取节点数据
     */
    public function getNodeInfo($id)
    {
        $result = $this->field('id,node_name,pid')->select();
        $str = "";

        $role = new UserType();
        $rule = $role->getRuleById($id);

        if(!empty($rule)){
            $rule = explode(',', $rule);
        }
        foreach($result as $key=>$vo){
            $str .= '{ "id": "' . $vo['id'] . '", "pId":"' . $vo['pid'] . '", "name":"' . $vo['node_name'].'"';

            if(!empty($rule) && in_array($vo['id'], $rule)){
                $str .= ' ,"checked":1';
            }

            $str .= '},';

        }

        return "[" . substr($str, 0, -1) . "]";
    }

    /**
     * 根据节点数据获取对应的菜单
     * @param $nodeStr
     */
    public function getMenu($nodeStr = '')
    {
        //超级管理员没有节点数组
        $where = empty($nodeStr) ? 'is_menu = 2' : 'is_menu = 2 and id in('.$nodeStr.')';

        $result = db('node')->field('id,node_name,pid,control_name,action_name,style')
            ->where($where)->select();
        $menu = prepareMenu($result);

        return $menu;
    }

    /**
     * 获取所有节点
     * @param $nodeStr
     */
    public function getAllMenu()
    {
        $result = db('node')->field('id,node_name,pid,control_name,action_name,style,level')
            ->select();
        foreach($result as $key=>$vo){
            if($vo['pid'] == 0){
                $result[$key]['href'] = '#';
            }else{
                $result[$key]['href'] = url($vo['control_name'] .'/'. $vo['action_name']); //跳转地址
            }
            unset($result[$key]['control_name']);
            unset($result[$key]['action_name']);
        }

        $menu = subTree($result);

        return $menu;
    }

    /*
     * 获取单个menu信息
     * @param id
     */
    public function getOneMenu($id){
        $node = new Node;
        $menu_info = $node::get($id);
        $menu = [
            'id' => $menu_info->id,
            'node_name' => $menu_info->node_name,
            'control_name' => $menu_info->control_name,
            'action_name' => $menu_info->action_name,
            'is_menu' => $menu_info->is_menu,
            'pid' => $menu_info->pid,
            'level' => $menu_info->level,
            'style' => $menu_info->style
        ];
        return $menu;
    }

    /*
     * 修改菜单
     */
    public function updateMenu($menu_info){
        $node = new Node;

        if($menu_info['pid'] == 0){
            $level = 1;
        }else{
            $pid_menu = $this->getOneMenu($menu_info['pid']);
            $level =  intval($pid_menu['level'])+1;
        }
        if(isset($menu_info['style'])){
            $style = $menu_info['style'];
        }else{
            $style = '';
        }
        try{
            $node::save(['node_name'=>$menu_info['node_name'],'pid'=>$menu_info['pid'],'control_name'=>$menu_info['control_name'],
                'action_name'=>$menu_info['action_name'],'is_menu'=>$menu_info['is_menu'],'level'=>$level,'style'=>$style
            ],['id'=>$menu_info['id']]);
            return ['code' => 1, 'data' => '', 'msg' => '修改菜单成功'];

        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /*
     * 添加菜单
     */
    public function addMenu($menu_info){
        $node = new Node;
        if($menu_info['pid'] == 0){
            $level = 1;
        }else{
            $pid_menu = $this->getOneMenu($menu_info['pid']);
            $level =  intval($pid_menu['level'])+1;
        }
        if(isset($menu_info['style'])){
            $style = $menu_info['style'];
        }else{
            $style = '';
        }
        try{
            $node::save(['node_name'=>$menu_info['node_name'],'pid'=>$menu_info['pid'],'control_name'=>$menu_info['control_name'],
                'action_name'=>$menu_info['action_name'],'is_menu'=>$menu_info['is_menu'],'level'=>$level,'module_name'=>'admin','style'=>$style
            ]);
            return ['code' => 1, 'data' => '', 'msg' => '修改菜单成功'];

        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }


}