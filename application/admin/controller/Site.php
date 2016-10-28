<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 2016/10/28
 * Time: 15:40
 */
namespace app\admin\controller;

class Site extends Base{
    public function index(){
        if(request()->isPost()){

        }else{

        }

        $this->assign(
            ['upload_path'=>'logo']
        );
        return $this->fetch();
    }
}