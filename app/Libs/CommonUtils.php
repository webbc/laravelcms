<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/20 0020
 * Time: 19:49
 */

namespace App\Libs;

use App\Admin;
use App\Perm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonUtils {

    public $admin = null;//管理员对象
    public $menu = null;//菜单对象
    public $mbx = null;//面包屑对象
    public $msg = null;//消息对象

    /**
     * 构造函数
     */
    public function __construct(Request $request) {
        $this->init($request);
    }

    /**
     * 初始化函数
     */
    private function init(Request $request) {
        $this->getAdmin($request);
        $this->getMsg();
        $this->getMenu($request);
        $this->getMbx($request);
    }

    /**
     * 获取管理员数据
     */
    private function getAdmin() {
        $this->admin = session('admin');
    }

    /**
     * 获取后台菜单数据
     */
    private function getMenu(Request $request) {
        $menu = DB::table('menu')->where('parentid', 0)->orderBy('sort')->get();
        $router = $request->getPathInfo();
        $perm = new Perm();
        $mbx = $perm->getMbx($router);
        foreach ($menu as $k => $m) {
            $m->active = '';
            //读取子菜单
            $childMenu = DB::table('menu')->where('parentid', $m->id)->orderBy('sort')->get();
            if (count($childMenu) > 0) {
                foreach($childMenu as $v){
                    $v->active = '';
                    if($mbx[0]->router == $v->router){
                        $v->active = 'active';
                        $m->active = 'active';
                    }
                }
                $m->childMenu = $childMenu;
            } else {
                $m->childMenu = null;
            }
        }
        $this->menu = $menu;
    }

    /**
     * 获取面包屑
     */
    private function getMbx(Request $request) {
        $router = $request->getPathInfo();
        $perm = new Perm();
        $mbx = $perm->getMbx($router);
        $this->mbx = $mbx;
    }

    /**
     * 获取未读消息
     */
    private function getMsg() {
        $adminModel = new Admin();
        $toId = $this->admin->id;
        $this->msg = $adminModel->getUnReadMsg($toId);
    }
}