<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
    /*配置验证规则*/
    protected $rule = [
        'username' => 'require|max:25|unique:admin',
        'password' => 'require',
    ];
    /*配置错误提示信息*/
    protected $message = [
        'username.require' => '管理员名称必须填写',
        'username.max' => '管理员名称长度必须小于25位',
        'username.unique' => '管理员名称不能重复',
        'password.require' => '管理员密码必须填写',
    ];
    /*配置验证场景*/
    protected $scene = [
    ];
}
