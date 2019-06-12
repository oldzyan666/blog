<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-28
 * Time: 下午4:31
 */

namespace app\admin\controller;

use think\Request;
use think\Controller;

class Common extends Controller
{

    public function __construct(Request $request = null){
        parent::__construct($request);
        if(is_null(session('user'))){
            $this->error('请先登录','login/login');
        }

        if (!$this->checkAuth()){
            $this->error('没有权限');
        }
    }


    public function checkAuth(){

        header("Content-Type:text/html;charset=utf-8");
        //　0　代表没有权限
        $hasPermission = 0;
        $request = Request::instance();

        $module = $request->module();
        $controller = $request->controller();
        $action = $request->action();

        //　根据用户名查询用户信息
        $user_info = db('admin')->where('user',session('user'))->find();
//         dump($user_info);die;

        // 根据用户ID查询对应的角色ID  一个用户可以拥有多个角色
        $role_ids = db('admin_role')->where('admin_id', $user_info['id'])->select();
//         dump($role_ids);die;

        // 如果 角色ID 有1（超级管理员） 默认拥有所有权限  没有就收集 角色ID
        $roleList = '';
        foreach ($role_ids as $k=>$v){
            if ($v['role_id'] == 1){
                $hasPermission = 1;
            }
            $roleList .= $v['role_id'].',';
        }
//         dump($roleList);die;

        if ($hasPermission == 1){
            $menus = db('permission')->where('type',0)->order('ords')->select();
            // dump($menus);die;
        }
        elseif ($hasPermission == 0){

            $roleList = rtrim($roleList,',');
//             dump($roleList);die;
            // 根据角色id查询 角色对应的权限id
            $permission_id = db('role_permission')->whereIn('role_id',$roleList)->select();
//             dump($permission_id);die;

            $permissionList = [];
            foreach ($permission_id as $k=>$v){

                $permissionList[] = $v['permission_id'];

            }

//            array_unique($permissionList);  //　　去重
//            dump($permissionList);die;
            $permissionList = implode(',',$permissionList); //  分割成字符串

//             dump($permissionList);die;

            // 查询用户的所有权限
            $permissions  = db('permission')->whereIn('id',$permissionList)->select();
//            dump($permissions);

            // 查询用户的type为0 的权限
            $menus = db('permission')->where('type',0)->whereIn('id',$permissionList)->order('ords')->select();
//            dump($menus);die;


            // 获取地址栏的模块　控制器　方法

//             echo strtolower($module.'/'.$controller.'/'.$action);die;

            foreach ($permissions as $k=>$v){
                if(strtolower($v['name']==strtolower($module.'/'.$controller.'/'.$action))){
                    $hasPermission = 1;
                    break;
                }
            }

        }

        $this->assign('menus',$menus);
        $this->assign('current_url',strtolower($module.'/'.$controller.'/'.$action));
//        dump($menus);die;
        return $hasPermission;

    }


}