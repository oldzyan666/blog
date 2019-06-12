<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 19-1-3
 * Time: 下午5:34
 */

namespace app\admin\controller;

use think\Request;

class Role extends Common
{

    // 角色列表
    public function role()
    {
        $search = input('get.search', '' , 'htmlspecialchars');
        $config = [];
        $page = input('get.page','1');
        $roles = db('role');
        if ($search!=''){
            $config = ['query'=>['search'=>$search]];
            $roles->whereLike('role_name',"%{$search}%");
        }

        $role = $roles->paginate(3,false,$config);
        $data = $role->toArray();
//        dump($data);die;
        if (empty($data['data'])) {
            $config['page'] = $page - 1 > 1 ? $page - 1 : 1;
            $role =$roles->paginate(3 , false , $config);
        }
        $page = $role->render();
        $search = ['pagination' , 'disabled' , 'active'];
        $replace = ['am-pagination tpl-pagination' , 'am-disabled' , 'am-active'];
        $page = str_replace($search , $replace , $page);


        $request = Request::instance();
        if ($request->isAjax()){

            return json(['role'=>$role,'page'=>$page]);

        }else{

            $this->assign('role',$role);
            $this->assign('page', $page);
        }

        return view();
    }

    // 新增角色
    public function insert(){
        return view();
    }

    public function store(){

        $post = input('post.','','htmlspecialchars');
        $res = db('role')->insert($post);

        if ($res){
            $this->success('添加成功',url('role'));
        }
        else{
            $this->error('添加失败');
        }
    }

    // 删除角色
    public function delete () {
        $id = input('get.id');
        $affectedRow = db('role')->where('id' , $id)->delete();
        if ($affectedRow) {
            $this->success('删除成功');
        }else {
            $this->error('删除失败');
        }
    }

    // 编辑角色
    public function edit(){
        $id = input('get.id','','intval');
        $res = db('role')->find($id);
        $this->assign('res',$res);
        return view();
    }

    public function save () {

        $post = input('post.');
//        print_r($post);die;

//        db('role')->update(['role_name'=>$post]);
        db('role')->update($post);

        $this->success('更新成功' , url('role'));

    }

    // 查看角色权限
    public function editPermission(){

        // 查询所有权限
        $permission = db('permission')->order('ords')->select();
//        dump($permission);die;

        $tmp_permission = $permission;

        foreach ($tmp_permission as $k=>$v){
            foreach ($tmp_permission as $k2=>$v2){

                if ($v2['pid'] == $v['id']){

                    $permission[$k]['son'][] = $v2;
                    unset($permission[$k2]);

                }
            }
        }

        //  print_r($permission);die;

        // 查询该角色有哪些角色

        $id = input('get.id');
        $hasPermission = db('rolePermission')->where('role_id',$id)->select();
//        print_r($hasPermission);die;


        $hasPermission2 = [];
        foreach ($hasPermission as $k=>$v){
            $hasPermission2[] = $v['permission_id'];
        }

//        print_r($hasPermission2);die;
          //print_r($permission);die;

        $this->assign('permission',$permission);
        $this->assign('hasPermission2',$hasPermission2);
        return view();

    }

    // 编辑角色权限
    public function savePermission(){

        $post = input('post.');

        db('role_permission')->where('role_id',$post['role_id'])->delete();

        //  dump($post['permission_id']);die;
        $insertData = [];
        foreach ($post['permission_id'] as $k=>$v){

            $insertData[$k]['role_id'] = $post['role_id'];
            $insertData[$k]['permission_id'] = $v;

        }

//        dump($insertData);die;
        db('role_permission')->insertAll($insertData);
        $this->success('更新成功',url('人哦乐'));
    }

}