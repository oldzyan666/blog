<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 19-1-3
 * Time: 上午9:58
 */

namespace app\admin\controller;
use think\Request;

class user extends Common
{
    // 前台会员列表页
    public function user(){
        $search = input('get.search');
        $config = [];
        $link = db('user');

        if ($search!=''){
            $config['query'] = ['search'=>$search];
            $link ->whereLike('name',"%{$search}%");
        }
        $ad_list = $link->paginate(3,false,$config);

        $data = $ad_list->toArray();
//        echo "<pre>";
//        print_r($data);die;
        if (empty($data['data'])) {
            $config['page'] = $config['page'] - 1 > 1 ? $config['page'] - 1 : 1;
            $ad_list =$link->paginate(3, false , $config);
        }

        $page = $ad_list->render();
        $search = ['pagination' , 'disabled' , 'active'];
        $replace = ['am-pagination tpl-pagination' , 'prev' , 'am-active'];
        $page = str_replace($search,$replace,$page);

        $request = Request::instance();
        if ($request->isAjax()){
            return Json(['ad_list'=>$ad_list,'page'=>$page]);
        }else
        {
            $this->assign('ad_list',$ad_list);
            $this->assign('page',$page);
        }

        return view();
    }

    // 删除前台会员
    public function delete_user(){

        $id = input('get.id');

        $affectedRow = db('user')->where('id',$id)->delete();
        if($affectedRow){
            $this->success('删除成功');
        }
        else{
            $this->error('删除失败');
        }
    }

    // 修改前台会员
    public function edit_user(){

        $id = input('get.id');
        $info = db('user')->find($id);
        $this->assign('info',$info);
        return view();
    }

    public function update(){

        $post = input('post.','','trim,htmlspecialchars');

//        print_r($post);die;
        $file = request()->file('img');
        // 移动到框架应用根目录/public/uploads/ 目录下

        if($file) {

            $info = db('link')->find($post['id']);
            if (file_exists(ROOT_PATH . 'public' .  DS .'static'.DS . 'uploads' . '/' . $info['img'])) {
                unlink(ROOT_PATH . 'public' . DS . 'static'.DS .'uploads' . '/' . $info['img']);
            }

            $info = $file->move(ROOT_PATH . 'public' . DS .'static'.DS. 'uploads');
            if($info){
                $post['img'] = $info->getSaveName();

                $info->getSaveName();

            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

        db('link')->where('id', $post['id'])->update($post);
        $this->success('更新成功',url('link'));

    }

    // 禁用启用前台会员
    public function status_user(){

        $id = input('get.id');
        $status = input('get.status');

        db('user')->where('id',$id)->update(['status'=>$status]);

    }

}