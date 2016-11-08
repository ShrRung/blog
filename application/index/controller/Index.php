<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

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
        if(request()->isPost()){
            $param = input('param.');
            $arrParams = [];
            parse_str(html_entity_decode(urldecode($param['data'])), $arrParams);
            return json($arrParams);
        }else{
            $confirm = md5('fdsah!@^*687'.time());
            Session::set('confirm',$confirm);
            $this->assign(
                ['confirm' => $confirm]
            );
        }
        return $this->fetch();
    }

}
