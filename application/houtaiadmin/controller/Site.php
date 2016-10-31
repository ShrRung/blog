<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 2016/10/28
 * Time: 15:40
 */
namespace app\houtaiadmin\controller;

class Site extends Base{
    public function index(){
        if(request()->isPost()){
            $param = input('post.');
            unset($param['file']);
//            $param = parseParams($param['data']);
            $res = db('config')->where('conf_id',1)->update($param);
            if($res){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }else{
            $site = db('config')->find();
        }

        $this->assign(
            [
                'upload_path'=>'logo',
                'site' => $site
            ]
        );
        return $this->fetch();
    }
}