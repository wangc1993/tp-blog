<?php
namespace app\index\controller;
use app\index\controller\Base;
class Category extends Base
{
    public function index()
    {
        $cateid=input('cateid');
        /*查询当前分类名*/
        $category=db('category')->find($cateid);
        $this->assign('category',$category);
        /*查询当前分类下的文章*/
        $articleList=db('article')->where(array('cateid'=>$cateid))->paginate(3);
        $this->assign('articleList',$articleList);
        return $this->fetch('category');
    }
}
