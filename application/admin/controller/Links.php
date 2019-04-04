<?php
namespace app\admin\controller;
use app\admin\controller\Base;
/*use think\Db;*/
use app\admin\model\Links as LinksModel;
class Links extends Base
{
    public function lst()
    {
        $model= new LinksModel();
        $list = LinksModel::paginate(3);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add()
    {
        if(request()->isPost()){
            $links = [
                'title'=>input('title'),
                'url'=>input('url'),
                'desc'=>input('desc')
            ];
            $validate = \think\Loader::validate('links');
            if(!$validate->scene('add')->check($links)){
                $this->error($validate->getError());
                die;
            }
            if(db('links')->insert($links)){
                return $this->success("添加链接成功！","lst");
            }else{
                return $this->error("添加链接失败！");
            }
            return;
        }
        return $this->fetch();
    }
    public function edit(){
        /*查询数据*/
        $id = input('id');
        $links = db('links')->find($id);
        /*判断edit页提交的数据*/
        if(request()->isPost()){
            $newlinks = [
                'id'=>input('id'),
                'title'=>input('title'),
                'url'=>input('url'),
                'desc'=>input('desc')
            ];
            $validate = \think\Loader::validate('links');
            if(!$validate->scene('edit')->check($newlinks)){
                $this->error($validate->getError());
                die;
            }
            if(db('links')->update($newlinks)){
                return $this->success("修改链接成功！","lst");
            }else{
                return $this->error("修改链接失败！");
            }
            return;
        }
        $this->assign('siplinks',$links);
        return $this->fetch();
    }
    public function del(){
        $id = input('id');
        if(db('links')->delete(input('id'))){
            $this->error('删除链接成功！','lst');
        }else{
            $this->error('删除链接失败！');
        }
    }
}
