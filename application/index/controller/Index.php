<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {

        $this->assign('list', 111);
        header("HTTP/1.0 404 Not Found");
        return $this->fetch();
    }

    public function hello()
    {
        return 'hello,thinkphp!';
    }

    public function test()
    {
        return '这是一个测试方法!';
    }

    protected function hello2()
    {
        return '只是protected方法!';
    }

    private function hello3()
    {
        return '这是private方法!';
    }
}
