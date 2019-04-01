<?php
namespace app\index\controller;
/*引入控制器文件*/
use think\Controller;
class Category extends Controller
{
    public function index()
    {
        return $this->fetch('category');
    }
}
