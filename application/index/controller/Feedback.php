<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-26
 * Time: 下午5:19
 */

namespace app\index\controller;

use think\Controller;
use think\Request;

class Feedback extends Controller
{
    public function feedback(Request $request){

        // 获取 用户的头像  留言时
        $posts = db('user')->where('id',session('id'))->find();
        $img = $posts['img'];
        session('img',$img);

//        $query = db('message')->order('id desc')->paginate(1,false,['query'=>['page'=>1]]);
//        $query = db('message')->order('id desc')->select();

        $count = db('message')->count();
        $query = db('message')->alias('a')->join('user b ','b.id= a.user_id')->paginate(2,false,['query'=>$request->param()]);
        $page = $query->render();


//        $request = Request::instance();
//        if ($request->isAjax()){
//            return json(['query'=>$query,'page'=>$page]);
//        }

        // print_r($query);die;


        // $query = $query->toArray();
        // print_r($query);die;

        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('query',$query);

        return view();

    }

    // 留言
    public function add_feedback(){

        $post = input('post.','','htmlspecialchars');
        $post['time'] = date('Y-m-d H:i:s');

//        if (!$post['content']){
//            $this->error('留言不能为空');
//        }

        //插入数据库
        $insertId = db('message')->insertGetId($post);
        if($insertId){
            $this->success('留言成功',url('feedback'));
        }
        else{
            $this->error('留言失败');
        }

    }

}