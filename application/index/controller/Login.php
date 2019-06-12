<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-28
 * Time: 下午4:55
 */

namespace app\index\controller;


use think\captcha\Captcha;
use think\Controller;
use think\Request;

class Login extends Controller
{
    //登录
    public function login()
    {
       return view();
    }

    // 前台登录
    public function login_in(){

        $post = input('post.','','htmlspecialchars');
//        $post['img'] = ['20190104/2210a3e09959b9f00c35ec03d76d6b33.jpg'];
//              print_r($post);die;
        $post['pwd'] = md5($post['pwd']);

        $select = db('user')->where(['user'=>$post['user'],'pwd'=>$post['pwd']])->select();

        /*||where(['email'=>$post['email'],'pwd'=>$post['pwd']])
        ||where(['pho'=>$post['pho'],'pwd'=>$post['pwd']])*/

        $code = $post['code'];
        if(!captcha_check($code)){
            $this->error('验证码错误');
        }

        if($select){
            $rs = current($select);
            // print_r($rs);die;

            if ($rs['status'] == 1){
                $this->error('会员已被限制登录',url('login/login'));
            }

            session('user',$post['user']);
            $post = db('user')->where('id',session('id'))->find();
            session('img',$post['img']);
            $query = db('user')->where('user',session('user'))->select();
            session('id',$query[0]['id']);

            $this->success('登录成功',url('index/index'));
            die;
        }else{
            $this->error('登录失败');
        }
    }

    // 前台退出
    public function login_out(){

        session('user',null);
//        Session::delete('user');
        $this->success('退出成功',url('login'));

    }

    // 登录验证码
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

    // 注册
    public function register()
    {
        return view();
    }

    public function checkUser(Request $request){

        header('Content-Type:text/html;charset=utf-8');

        $post = input('post.','','htmlspecialchars');
        $post['pwd'] = md5($post['pwd']);

        // 默认性别 头像
        $post['sex'] = '男';
        $post['img'] = '20190104/2210a3e09959b9f00c35ec03d76d6b33.jpg';

        $user = $request->post('user');
        $email = $request->post('email');
        $pho = $request->post('pho');

        if (empty($user)){
            $this->error('用户名不能为空',url('login/register'));
        }
        if (empty($email)){
            $this->error('邮箱不能为空',url('login/register'));
        }
        if (empty($user)){
            $this->$pho('手机号不能为空',url('login/register'));
        }

        $is_user = db('user')->where('user',$user)->count();
        $is_email = db('user')->where('email',$email)->count();
        $is_pho = db('user')->where('pho',$pho)->count();
        if($is_user)
        {
            $this->error('用户名已存在',url('login/register'));
        }
        if($is_email)
        {
            $this->error('邮箱已存在',url('login/register'));
        }
        if($is_pho)
        {
            $this->error('号码已存在',url('login/register'));
        }

        $query = db('user')->insert($post);

        if ($query) {
            session('user',$post['user']);
//            session('img',$post['img']);
            $query = db('user')->where('user',session('user'))->select();
            session('id',$query[0]['id']);
            $this->success('注册成功', url('index/index'));
        } else {
            $this->error('注册失败');
        }

    }

}