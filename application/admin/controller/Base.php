<?php
namespace app\admin\controller;
/*引入控制器文件*/
use think\Controller;
class Base extends Controller
{
    public function _initialize(){
        if(!session('username')){
            $this->error('请先登录系统！','Login/index');
        }
    }
}
