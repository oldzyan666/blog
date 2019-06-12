<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-29
 * Time: 下午12:21
 */

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Article extends Controller
{

    // 文章列表
    public function article(){

//        "SELECT user_id,username,max(score) FROM think_score GROUP BY user_id"


        $sql = "SELECT count(id) as total,DATE_FORMAT(time,'%Y-%m') as mytime FROM article GROUP BY DATE_FORMAT(time,'%Y-%m')";
        $tmplist = Db::query($sql);

        foreach($tmplist as $key=>$value){
            $sql = "SELECT id,title,DATE_FORMAT(time,'%m-%d') as mytime FROM article WHERE DATE_FORMAT(time,'%Y-%m')='".$value['mytime']."'";
            $rslist = Db::query($sql);
            if($rslist){
                $value['rslist'] = $rslist;
            }
            $tmplist[$key] = $value;
        }

//              echo '<pre>';
//              print_r($tmplist);

        $this->assign('tmplist',$tmplist);

        return view();

    }

    // 文章详情
    public function article_content(Request $request){
        $id = input('get.id');
        $pages = input('get.page');
        $config = [];
        if ($pages!=''){
            $config['query']=['id'=>$id];
        }
//        print_r($id);die;
        $que = db('article')->where('id',$id)->select();
        $ques = '';
        foreach ($que as $key=>$value){
            $ques = $value;
        }

        $this->assign('ques',$ques);

//        $comment = db('comment')->where('pid',$id)->order('id desc')->paginate(1,false,['query'=>$request->param()]);
//        $comment = db('comment')->where('pid',$id)->order('id desc')->select();

        $comment = db('comment')->alias('a')->join('user b','a.user_id = b.id')->paginate(1,false,['query'=>$request->param()]);

        //  print_r($comment);die;
        $page = $comment->render();
        $search = ['pagination' , 'disabled' , 'active'];
        $replace = ['prev page-numbers' , 'page-numbers' , 'current page-numbers'];
        $page = str_replace($search,$replace,$page);

        //->limit(0,5)

        //print_r($comment);die;
        $this->assign('page',$page);
        $this->assign('id',$id);
        $this->assign('comment',$comment);

        // 检测是否赞过
        $query = db('zan')->where('article_id',$id)->where('user_id',session('id'))->find();
        if ($query){
            $this->assign('is_zan',true);
        }else{
            $this->assign('is_zan',false);
        }

        return view();
    }

    // 文章评论
    public function comment(){

        $post = input('post.');
        $post['time'] = date("Y-m-d H:i:s");

        if (!$post['content']){
            $this->error('评论不能为空');
        }
        //print_r($post);die;

        $query = db('comment')->insert($post);
        if ($query){
            $this->success('评论成功',url('article_content').'?id='.$post['pid']);
        }
        else{
            $this->error('评论失败',url('article_content').'?id='.$post['pid']);
        }
    }

    // 点赞
    public function zan(){

        if (!session('user')){
            $this->error('您还未登录,请先登录在点赞');
        }

        $id= input('post.id');
        if (!$id){
            $this->error('未指定主题ID');
        }

        $query = db('zan')->where('article_id',$id)->where('user_id',session('id'))->find();
        if ($query){
            $this->error('您已经点过赞了',url('article_content'));
        }

        db('article')->where('id',$id)->setInc('zan',1);

        $data = ['article_id' => $id, 'user_id' => session('id'),'time'=>date('Y-m-d')];
        $query = db('zan')->insert($data);
        if ($query){
            $this->success(url('article_content'));
        }

    }

}