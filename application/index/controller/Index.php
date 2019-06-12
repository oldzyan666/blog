<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{

    // 首页 调用文章详情页数据
    public function index ()
    {

        $query = db('article')->paginate(1);
        $page = $query->render();

        $this->assign('page',$page);
        $this->assign('query',$query);

        return view();
    }
}
