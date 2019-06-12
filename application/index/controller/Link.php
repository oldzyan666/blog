<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 18-12-29
 * Time: 上午9:34
 */

namespace app\index\controller;


use think\Controller;

class Link extends Controller
{
    public function link(){

       $query = db('link') ->limit(4)->select();

       $this->assign('query',$query);
       return view();
    }
}