<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 2016/10/27
 * Time: 14:17
 */
namespace app\admin\controller;

use think\Controller;

class File extends Controller{
    /*
     * 上传图片
     */
    public function imageUp($type = 'images'){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.$type);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getSaveName();
            return DS.'uploads'.DS.$type.DS.$info->getSaveName();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

}