<?php
namespace app\houtaiadmin\controller;

use app\houtaiadmin\model\UserModel;

class Personnel extends Base{
    public function change_password(){
        if(request()->isPost()){
            $param = input('post.');
            if($param['password'] != $param['confirm_password']){
                $this->error('两次输入密码不一致');
            }

            $model_personnel = new UserModel();
            $flag = $model_personnel->changePassword($param['id'],$param['password']);
            if($flag['code'] == 1){
                $this->success('修改成功');
            }else{
                $this->error($flag['msg']);
            }

        }else{
            return $this->fetch();
        }
    }
}