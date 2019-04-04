<?php
namespace app\admin\controller;
/*use think\Db;*/
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Base;
class Admin extends Base
{
    public function lst()
    {
        $model= new AdminModel();
        $list = AdminModel::paginate(3);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add()
    {
        /*request()->isPost()判断是否有提交*/
        if(request()->isPost()){
            $admin = [
                'username'=>input('username'),
                'password'=>input('password')
            ];
            $validate = \think\Loader::validate('Admin');
            if(!$validate->check($admin)){
                $this->error($validate->getError());
                die;
            }
            $admin['password'] = md5(input('password'));
            /*if(Db::name('admin')->insert($admin)){*/
            /*db助手函数进行添加（方便）*/
            if(db('admin')->insert($admin)){
                return $this->success("添加管理员成功！","lst");
            }else{
                return $this->error("添加管理员失败！");
            }
            return;
        }
        return $this->fetch();
    }
    public function edit(){
        /*查询数据*/
        $id = input('id');
        $admin = db('admin')->find($id);
        /*判断edit页提交的数据*/
        if(request()->isPost()){
            $newAdmin = [
                'id'=>input('id'),
                'username'=>input('username'),
                'password'=>input('password')
            ];
            /*将现密码与原始密码（加密的）进行比较*/
            if(input('password') != $admin['password']){
                $newAdmin['password'] = md5(input('password'));
            };
            $validate = \think\Loader::validate('Admin');
            if(!$validate->check($newAdmin)){
                $this->error($validate->getError());
                die;
            }
            if(db('admin')->update($newAdmin)){
                return $this->success("修改管理员成功！","lst");
            }else{
                return $this->error("修改管理员失败！");
            }
            return;
        }
        $this->assign('sipAdmin',$admin);
        return $this->fetch();
    }
    public function del(){
        $id = input('id');
        /*不能删除初始管理员*/
        if($id != 1){
            if(db('admin')->delete(input('id'))){
                $this->error('删除管理员成功！','lst');
            }else{
                $this->error('删除管理员失败！');
            }
        }else{
            $this->error('初始化管理员不能删除！');
        }
    }
    public function logout(){
        session(null);
        $this->success('退出成功！','Login/index');
    }
}
