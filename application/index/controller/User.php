<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/30
 * Time: 12:51
 */

namespace app\index\controller;

use think\Session;
class User extends Common
{

    // 个人中心页
    public function user(){

        // 我的留言
        $message = db('message')->where('user_id',session('id'))->select();
        $this->assign('message',$message);

        // 我的点赞
        $zan = db('zan')->where('user_id',session('id'))->select();
        $zans = [];
        foreach ($zan as $k=>$v){
            $zans[] = $v['article_id'];
        }
        $article_id = implode(',',$zans);
        $my_zan = db('article')->whereIn('id',$article_id)->select();
        $this->assign('my_zan',$my_zan);

        // 我的评论
        $comment = db('comment')->where('user_id',session('id'))->select();
        // print_r($comment);die;
        $this->assign('comment',$comment);

        // 个人信息
        $query = db('user')->where('id',session('id'))->select();
        $this->assign('query',$query);

        return view();

    }

    //  删除留言
    public function del_message(){
        $id = input('get.id');
        $query = db('message')->where('id',$id)->delete();
        if ($query){
            $this->success('删除成功',url('user'));
        }
    }

    //  删除评论
    public function del_comment(){
        $id = input('get.id');
        $query = db('comment')->where('id',$id)->delete();
        if ($query){
            $this->success('删除成功',url('user'));
        }
    }

    //  取消点赞
    public function del_zan(){
        $id = input('get.id');
        db('article')->where('id',$id)->setDec('zan',1);
        $query = db('zan')->where('article_id',$id)->where('user_id',session('id'))->delete();
        if ($query){
            $this->success('取消点赞成功');
        }
    }

    // 编辑个人信息
    public function edit_personal(){

        $post = input('post.');

//        print_r($post);die;

        $file = request()->file('img');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS .'static' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $post['img'] = $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }


        $query = db('user')->where('id',session('id'))->update($post);

//        print_r($query);die;
        if ($query){
//            halt($img);
            $this->success('修改成功');


        }
    }


}