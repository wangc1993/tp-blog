<?php
namespace app\index\controller;
use app\index\controller\Base;
class Article extends Base
{
    public function index()
    {
        $arid=input('arid');
        $article=db('article')->find($arid);
        $relateList=$this->ralat($article['keywords'],$article['id']);
        /*增加点击量*/
        db('article')->where('id','=',$arid)->setInc('click');
        $category=db('category')->find($article['cateid']);
        /*频道推荐*/
        $recList=db('article')->where(array('cateid'=>$category['id'],'state'=>1))->limit(8)->select();
        $this->assign(array(
            'article'=>$article,
            'category'=>$category,
            'recList'=>$recList,
            'relateList'=>$relateList
        ));
        return $this->fetch('article');
    }

    public function ralat($keywords,$id){
        /*字符串打散为数组*/
        $arr=explode(',', $keywords);
        static $relateList=array();
        foreach ($arr as $key => $value) {
            $map['keywords']=['like','%'.$value.'%'];
            $map['id']=['neq',$id];
            /*获取相关推荐*/
            $artres=db('article')->where($map)->order('id desc')->limit(8)->select();
            /*放入数组*/
            $relateList=array_merge($relateList,$artres);
        }
        if($relateList){
            $relateList=arr_unique($relateList);
            return $relateList;
        }
    }
}
