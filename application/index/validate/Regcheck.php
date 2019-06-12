<?php
namespace app\index\validate;

use think\Validate;

class Regcheck extends Validate
{
    protected $rule = [
        'user'  =>  'require|alphaDash|min:5|max:15',
        'pwd' =>  'require|min:6|alphaDash',
        'pho' => 'require|number|length:11',
        'email'=> 'require'
    ];

    protected $message = [
        'user.require' => '请输入用户名',
        'user.alphaDash' => '用户名不符合规定',
        'user.min' => '用户名最少5位',
        'user.max' => '用户名最多15位',
        'pho.require' => '手机号不能为空',
        'pho.number' => '这不是手机号码',
        'pho.length' => '手机号码长度不对',
        'email.require' => '邮箱不能为空',
        'pwd.alphaDash' => '用户名不符合规定',
        'pwd.require' => '密码不能为空',
        'pwd.min' => '密码不能少于6位',


    ];
}
?>