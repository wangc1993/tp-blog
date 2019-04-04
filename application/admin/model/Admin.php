<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class Admin extends Model
{
    /*登录逻辑*/
    public function login($data){
        $captcha = new \think\captcha\Captcha();
        if (!$captcha->check($data['code'])) {
            /*验证码错误*/
            return 4;
        }
        $user=Db::name('admin')->where('username','=',$data['username'])->find();
        /*用户是否存在*/
        if($user){
            if($user['password'] == md5($data['password'])){
                session('username',$user['username']);
                session('uid',$user['id']);
                /*登录成功*/
                return 1;
            }else{
                /*密码错误*/
                return 2;
            }
        }else{
            /*用户不存在*/
            return 3;
        }
    }
}
