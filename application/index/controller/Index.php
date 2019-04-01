<?php
namespace app\index\controller;
/*引入控制器文件*/
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        /*引入模板文件*/
        return $this->fetch();
    }
}
