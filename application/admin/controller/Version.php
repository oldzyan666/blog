<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-28
 * Time: 上午10:53
 */

namespace app\admin\controller;

use think\Request;

class version extends Common
{
    // 版本列表页
    public function version(){
        $search = input('get.search');
        $config = [];
        $link = db('version');

        if ($search!=''){
            $config['query'] = ['search'=>$search];
            $link ->whereLike('title',"%{$search}%");
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
        $replace = ['am-pagination tpl-pagination' , 'am-disabled' , 'am-active'];
        $page = str_replace($search,$replace,$page);

        $request = Request::instance();
        if ($request->isAjax()){
            return Json(['ad_list'=>$ad_list,'page'=>$page]);
        }

        $this->assign('ad_list',$ad_list);
        $this->assign('page',$page);
        return view();
    }

    // 新增版本
    public function add_version(){

        return view();

    }

    public function add(){

        $post = input('post.','','htmlspecialchars');

        //插入数据库
        $insertId = db('version')->insertGetId($post);
        if($insertId){
            $this->success('新增成功',url('version/version'));
        }
        else{
            $this->error('新增失败');
        }
    }

    // 删除版本
    public function delete_version(){

        $id = input('get.id');

        $affectedRow = db('version')->where('id',$id)->delete();
        if($affectedRow){
            $this->success('删除成功');
        }
        else{
            $this->error('删除失败');
        }
    }

    // 修改版本
    public function edit_version(){

        $id = input('get.id');
        $info = db('version')->find($id);
        $this->assign('info',$info);
        return view();
    }

    public function update(){

        $post = input('post.','','trim,htmlspecialchars');


        db('version')->where('id', $post['id'])->update($post);
        $this->success('更新成功',url('version'));

    }

}