<?php
/**
 * Created by PhpStorm.
 * User: admin123
 * Date: 19-1-3
 * Time: 上午8:54
 */

namespace app\index\controller;

use think\Controller;
use think\Request;

class Common extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if (is_null(session('user'))){
            $this->error('请先登录','login/login');
        }
    }
}