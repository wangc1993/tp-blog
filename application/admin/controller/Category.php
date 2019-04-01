<?php
namespace app\admin\controller;
/*引入控制器文件*/
use think\Controller;
/*use think\Db;*/
use app\admin\model\Category as CategoryModel;
class Category extends Controller
{
    public function lst()
    {
        $model= new CategoryModel();
        $list = CategoryModel::paginate(3);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add()
    {
        if(request()->isPost()){
            $category = [
                'categoryname'=>input('categoryname'),
            ];
            $validate = \think\Loader::validate('category');
            if(!$validate->scene('add')->check($category)){
                $this->error($validate->getError());
                die;
            }
            if(db('category')->insert($category)){
                return $this->success("添加分类成功！","lst");
            }else{
                return $this->error("添加分类失败！");
            }
            return;
        }
        return $this->fetch();
    }
    public function edit(){
        /*查询数据*/
        $id = input('id');
        $category = db('category')->find($id);
        /*判断edit页提交的数据*/
        if(request()->isPost()){
            $newCategory = [
                'id'=>input('id'),
                'categoryname'=>input('categoryname')
            ];
            $validate = \think\Loader::validate('category');
            if(!$validate->check($newCategory)){
                $this->error($validate->getError());
                die;
            }
            if(db('category')->update($newCategory)){
                return $this->success("修改分类成功！","lst");
            }else{
                return $this->error("修改分类失败！");
            }
            return;
        }
        $this->assign('sipCategory',$category);
        return $this->fetch();
    }
    public function del(){
        $id = input('id');
        if(db('category')->delete(input('id'))){
            $this->error('删除分类成功！','lst');
        }else{
            $this->error('删除分类失败！');
        }
    }
}
