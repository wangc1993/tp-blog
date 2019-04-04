<?php
namespace app\index\controller;
/*引入控制器文件*/
use think\Controller;
class Base extends Controller
{
    public function _initialize(){
        $this->right();
        $cateList = db('category')->order('id asc')->select();
        $tagList = db('tags')->order('id asc')->select();
        $this->assign(array(
            'cateList'=>$cateList,
            'tagList'=>$tagList
        ));
    }

    public function right(){
        $clickList=db('article')->order('click desc')->limit(5)->select();
        $tjres=db('article')->where('state','=',1)->order('click desc')->limit(5)->select();
        $this->assign(array(
                'clickList'=>$clickList,
                'tjres'=>$tjres
            ));
    }
}
