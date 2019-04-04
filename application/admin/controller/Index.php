<?php
namespace app\admin\controller;
use app\admin\controller\Base;
class Index extends Base
{
    public function index()
    {
        /*引入模板文件*/
        return $this->fetch();
    }
}
