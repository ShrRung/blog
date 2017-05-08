<?php
/**
 * Created by PhpStorm.
 * User: shrrung
 * Date: 17/5/7
 * Time: 12:09
 */
namespace app\index\controller;

use think\Controller;

class Api extends Controller{
    public function index(){
        $this->fetch();
    }
    public function left(){
        $this->fetch();
    }
    public function right(){
        $this->fetch();
    }
}