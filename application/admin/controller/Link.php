<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-27
 * Time: 上午10:02
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Link extends Common
{

    // 友情链接列表页
    public function link(){
        $search = input('get.search');
        $config = [];
        $link = db('link');

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

    // 新增友情链接
    public function add_link(){

        return view();

    }

    public function add(){

        $post = input('post.','','htmlspecialchars');

        // 获取表单上传文件 例如上传了001.jpg
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

        //插入数据库
        $insertId = db('link')->insertGetId($post);
        if($insertId){
            $this->success('新增成功',url('link/link'));
        }
        else{
            $this->error('新增失败');
        }
    }

    // 删除友情链接
    public function delete_link(){

        $id = input('get.id');

        $affectedRow = db('link')->where('id',$id)->delete();
        if($affectedRow){
            $this->success('删除成功');
        }
        else{
            $this->error('删除失败');
        }
    }

    // 修改友情链接
    public function edit_link(){

        $id = input('get.id');
        $info = db('link')->find($id);
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

}
