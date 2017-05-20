<?php
/**
 * 首页控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20 0020
 * Time: 20:15
 */

namespace App\Http\Controllers\Admin;

use App\Libs\ServerUtils;

class IndexController {

    //首页
    public function index() {
        $serverInfo = ServerUtils::getServerInfo();
        return view('admin.index.index', ['serverInfo' => $serverInfo]);
    }

}