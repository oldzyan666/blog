<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 19-1-3
 * Time: 上午9:34
 */

namespace app\admin\controller;

use think\Request;

class Feedback extends Common
{

    // 留言列表页
    public function feedback(){
        $search = input('get.search');
        $config = [];
        $link = db('message');

        if ($search!=''){
            $config['query'] = ['search'=>$search];
            $link ->whereLike('content',"%{$search}%");
        }
        $ad_list = $link->paginate(2,false,$config);

//        print_r($ad_list);die;

        $data = $ad_list->toArray();
//        echo "<pre>";
//        print_r($data);die;
        if (empty($data['data'])) {
            $config['page'] = $config['page'] - 1 > 1 ? $config['page'] - 1 : 1;
            $ad_list =$link->paginate(2, false , $config);
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

    // 删除留言
    public function delete_feedback(){

        $id = input('get.id');

        $affectedRow = db('message')->where('id',$id)->delete();
        if($affectedRow){
            $this->success('删除成功');
        }
        else{
            $this->error('删除失败');
        }
    }

}