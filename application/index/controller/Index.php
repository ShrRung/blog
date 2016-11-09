<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\CommentModel;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function about()
    {
        return $this->fetch();
    }

    public function contact(){
        if(request()->isAjax()){
            $param = input('param.');
            $arrParams = [];
            parse_str(html_entity_decode(urldecode($param['data'])), $arrParams);
            $model = new CommentModel();
            $falg = $model->addComment($arrParams,request()->ip());
            return json_encode(array('code' => $falg['code'], 'data' => '', 'msg' => $falg['msg']));
        }

        $confirm = md5('fdsah!@^*687'.time());
        Session::set('confirm',$confirm);
        $this->assign(
            ['confirm' => $confirm]
        );
        return $this->fetch();


    }

}
