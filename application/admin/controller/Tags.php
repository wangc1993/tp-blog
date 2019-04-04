<?php
namespace app\Admin\controller;
// use app\Admin\model\Tags as TagsModel;
use app\admin\controller\Base;
class Tags extends Base
{
    public function lst()
    {
    	$list = db('tags')->paginate(3);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        /*先获取分类*/
        $cateList=db('category')->select();
        $this->assign('cateList',$cateList);
    	if(request()->isPost()){

			$data=[
    			'tagname'=>input('tagname'),
    		];
    		$validate = \think\Loader::validate('Tags');
    		if(!$validate->scene('add')->check($data)){
			   $this->error($validate->getError()); die;
			}
    		if(db('Tags')->insert($data)){
    			return $this->success('添加Tag标签成功！','lst');
    		}else{
    			return $this->error('添加Tag标签失败！');
    		}
    		return;
    	}
        return $this->fetch();
    }

    public function edit(){
        /*先获取分类*/
        $cateList=db('category')->select();
        $this->assign('cateList',$cateList);
    	$id=input('id');
    	$Tags=db('Tags')->find($id);
    	if(request()->isPost()){
    		$data=[
    			'id'=>input('id'),
                'tagname'=>input('tagname'),
    		];
			$validate = \think\Loader::validate('Tags');
    		if(!$validate->scene('edit')->check($data)){
			   $this->error($validate->getError()); die;
			}
    		if(db('Tags')->update($data)){
    			$this->success('修改Tag标签成功！','lst');
    		}else{
    			$this->error('修改Tag标签失败！');
    		}
    		return;
    	}
    	$this->assign('Tags',$Tags);
    	return $this->fetch();
    }

    public function del(){
    	$id=input('id');
		if(db('Tags')->delete(input('id'))){
			$this->success('删除Tag标签成功！','lst');
		}else{
			$this->error('删除Tag标签失败！');
		}

    }



}
