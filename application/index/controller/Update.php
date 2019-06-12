<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-26
 * Time: 下午5:05
 */

namespace app\index\controller;


use think\Controller;

class Update extends Controller
{

    public function index(){
        $query = db('version')->select();
        $this->assign('query',$query);
        return view();
    }

}