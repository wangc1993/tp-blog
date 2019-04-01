<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate
{
    protected $rule = [
        'categoryname'  =>  'require|max:25|unique:category',
    ];

    protected $message  =   [
        'categoryname.require' => '栏目名称必须填写',
        'categoryname.max' => '栏目名称长度不得大于25位',
        'categoryname.unique' => '栏目名称不得重复',

    ];

    protected $scene = [
        'add'  =>  ['categoryname'=>'require|unique:category'],
        'edit'  =>  ['categoryname'=>'require|unique:category'],
    ];
}
