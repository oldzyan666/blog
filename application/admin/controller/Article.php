<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-29
 * Time: 下午12:18
 */

namespace app\admin\controller;

use think\Request;

class Article extends Common
{

    // 文章列表页
    public function article(){
        $search = input('get.search');
        $config = [];
        $link = db('article');

        if ($search!=''){
            $config['query'] = ['search'=>$search];
            $link ->whereLike('title',"%{$search}%");
        }
        $ad_list = $link->paginate(1,false,$config);

        $data = $ad_list->toArray();

//        echo "<pre>";
//        print_r($data);die;

        if (empty($data['data'])) {
            $config['page'] = $config['page'] - 1 > 1 ? $config['page'] - 1 : 1;
            $ad_list =$link->paginate(3, false , $config);
        }

        $page = $ad_list->render();
        $search = ['pagination' , 'disabled' , 'active'];
        $replace = ['am-pagination tpl-pagination' , 'am-disabled' , 'am-active'];
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

    // 新增文章
    public function add_article(){
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
        $insertId = db('article')->insertGetId($post);
        if($insertId){
            $this->success('新增成功',url('article/article'));
        }
        else{
            $this->error('新增失败');
        }
    }

    // 删除文章
    public function delete_article(){

        $id = input('get.id');

        $affectedRow = db('article')->where('id',$id)->delete();
        if($affectedRow){
            $this->success('删除成功');
        }
        else{
            $this->error('删除失败');
        }
    }

    // 修改文章
    public function edit_article(){

        $id = input('get.id');
        $info = db('article')->find($id);
        //  print_r($info);die;
        $this->assign('info',$info);
        return view();
    }

    public function update(){

        $post = input('post.','','trim,htmlspecialchars');

        //   print_r($post);die;
        $file = request()->file('img');
        // 移动到框架应用根目录/public/uploads/ 目录下

        if($file) {

            $info = db('article')->find($post['id']);
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

        db('article')->where('id', $post['id'])->update($post);
        $this->success('更新成功',url('article'));

    }
}