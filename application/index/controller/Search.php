<?php
namespace app\index\controller;
use app\index\controller\Base;
class Search extends Base
{
    public function index()
    {
        $keywords=input('keywords');
        if($keywords){
            /*搜索标题里含关键字的*/
            $where['title']=['like','%'.$keywords.'%'];
            $map['keywords']=['like','%'.$keywords.'%'];
            $searchList=db('article')->where($where)->whereOr($map)->order('id desc')->paginate($listRows = 3, $simple = false, $config = [
                'query'=>array('keywords'=>$keywords),
                ]);
            /*dump($searchList);die;*/
            $this->assign(array(
                'searchList'=>$searchList,
                'keywords'=>$keywords
                ));
        }else{
            $this->assign(array(
                'searchList'=>null,
                'keywords'=>'暂无数据'
                ));
        }
        return $this->fetch('search');
    }




}
