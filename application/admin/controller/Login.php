<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-28
 * Time: 下午2:25
 */

namespace app\admin\controller;
use think\captcha\Captcha;
use think\Controller;
use think\Session;

class Login extends Controller
{

    public function login(){
        return view();
    }

    // 登录
    public function login_in(){
        $post = input('post.','','htmlspecialchars');
        $post['password'] = md5($post['password']);

        $select = db('admin')->where(['user'=>$post['user'],'password'=>$post['password']])->count();

        $code = $post['code'];
        if(!captcha_check($code)){
            $this->error('验证码错误');
        }

        if($select){
            session('user',$post['user']);
            $this->success('登录成功',url('index/index'));
            die;
        }else{
            $this->error('登录失败');
        }
    }

    //登录验证码
    public function code(){
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    40,
            // 验证码位数
            'length'      =>    4,
            // 关闭验证码杂点
            'useNoise'    =>    false,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    // 退出
    public function login_out(){

        Session::delete('user');
        $this->success('退出成功',url('login'));

    }
}