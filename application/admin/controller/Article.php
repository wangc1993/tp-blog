<?php
namespace app\Admin\controller;
use app\Admin\model\Article as ArticleModel;
use app\Admin\controller\Base;
class Article extends Base
{
    public function lst()
    {
        $list = ArticleModel::paginate(3);
    	$this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
			$data=[
    			'title'=>input('title'),
                'author'=>input('author'),
                'desc'=>input('desc'),
                'keywords'=>str_replace('，', ',', input('keywords')),
                'content'=>input('content'),
                'cateid'=>input('cateid'),
    			'time'=>time(),
            ];
            /*推荐状态转化*/
            if(input('state')=='on'){
                $data['state']=1;
            }
            if($_FILES['pic']['tmp_name']){
                $file = request()->file('pic');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                $data['pic']='/uploads/'.$info->getSaveName();
            }
    		$validate = \think\Loader::validate('Article');
    		if(!$validate->scene('add')->check($data)){
			   $this->error($validate->getError()); die;
			}
    		if(db('article')->insert($data)){
    			return $this->success('添加文章成功！','lst');
    		}else{
    			return $this->error('添加文章失败！');
    		}
    		return;
    	}
        /*先获取分类*/
        $cateres=db('category')->select();
        $this->assign('cateres',$cateres);
        return $this->fetch();
    }

    public function edit(){
    	$id=input('id');
    	$articles=db('Article')->find($id);
    	if(request()->isPost()){
    		$data=[
    			'id'=>input('id'),
                'title'=>input('title'),
                'author'=>input('author'),
                'desc'=>input('desc'),
                'keywords'=>str_replace('，', ',', input('keywords')),
                'content'=>input('content'),
                'cateid'=>input('cateid'),
    		];
            if(input('state')=='on'){
                $data['state']=1;
            }else{
                $data['state']=0;
            }
            if($_FILES['pic']['tmp_name']){
                /*删除之前的缩略图*/
                $filename = ROOT_PATH . 'public/static' . $articles['pic'];
                @unlink($filename);
                $file = request()->file('pic');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                $data['pic']='/uploads/'.$info->getSaveName();
            }
			$validate = \think\Loader::validate('Article');
    		if(!$validate->scene('edit')->check($data)){
			   $this->error($validate->getError()); die;
			}
    		if(db('Article')->update($data)){
    			$this->success('修改文章成功！','lst');
    		}else{
    			$this->error('修改文章失败！');
    		}
    		return;
    	}
    	$this->assign('articles',$articles);
        $cateres=db('category')->select();
        $this->assign('cateres',$cateres);
    	return $this->fetch();
    }

    public function del(){
    	$id=input('id');
		if(db('Article')->delete(input('id'))){
			$this->success('删除文章成功！','lst');
		}else{
			$this->error('删除文章失败！');
		}

    }



}
