<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use app\index\model\CommentModel;
use Catclass\Sms\Alidayu;

class Index extends Controller
{
    public function index()
    {
        $this->assign([
            'index' => 'current'
        ]);
        return $this->fetch();
    }

    public function about()
    {
        $this->assign([
            'about' => 'current'
        ]);
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
        $this->assign([
            'confirm' => $confirm,
            'contact' => 'current'
        ]);
        return $this->fetch();
    }

    public function books(){
        if(request()->isPost()){
            $mobile = input('mobile');
            $SignName = '懒猫博客';
            $config = [
                'sms_product'        => '个人测试公司',
                'app_key'            => '23744254',
                'secret_key'         => '84471fa578985654c3b75ee733342756',
                'format'             => 'json',
                'api_version'        => '2.0',
                'sign_method'        => 'md5',
                'signature' => '懒猫博客',
                'sms_templateForm'  => '',
                'sms_templateCode'   => 'SMS_60870256'
            ];
            $code = '1234';
            $name = '测试公司1234';
            //模板
            $sms_templateForm = "{\"code\":\"$code\",\"name\":\"$name\"}";     //设置参数绑定
            $sms_templateCode = 'SMS_60870256';//模板code
            header("Content-type: text/html; charset=utf-8");
            $alidayu = new Alidayu($config);
            $alidayu->sendSMS($mobile,$SignName,'xuy',$sms_templateForm,$sms_templateCode);
            exit();
        }

        $this->assign([
            'books' => 'current'
        ]);

        return $this->fetch();
    }

    public function blog(){
        $this->assign([
            'blog' => 'current'
        ]);
        return $this->fetch();
    }

}
