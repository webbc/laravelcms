<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Perm extends Model {
    protected $table = 'perm';

    public $timestamps = false;

    /**
     * 根据当前路由来获取面包屑
     * @param $router 当前路由
     * @return array 面包屑数组
     */
    public function getMbx($router) {
        $mbx = [];
        $actions = $this->select('parentid', 'name', 'router')->where('parentid', '<>', 0)->get();
        foreach ($actions as $v) {
            if (strpos($router, $v->router) === 0) {
                $mbx[] = $v;
            }
        }
        $mbx[] = $this->select('name', 'router')->where('id', $mbx[0]->parentid)->first();
        return array_reverse($mbx);
    }

    /**
     * 获取指定操作url的权限id
     * @param $url 操作地址
     * @return int 权限id
     */
    private function getPermId($url) {
        $actions = $this->select('id', 'router')->where('parentid', '<>', 0)->get();
        foreach ($actions as $v) {
            if (strpos($url, $v->router) === 0) {
                return $v->id;
            }
        }
        return false;
    }

    /**
     * 检测某个角色组是否有指定权限
     * @param $rid角色id
     * @param $url操作地址
     * @return bool是否有权限
     */
    public function checkAdminPerm($rid, $url) {
        $role = Role::find($rid);
        if ($role->parentid != 0) {//不属于超级管理员
            $permId = $this->getPermId($url);
            $perms = DB::table('role_perm')->select('pid')->where('rid', $rid)->get();
            $pids = [];
            foreach ($perms as $perm) {
                $pids[] = $perm->pid;
            }
            if (!in_array($permId, $pids)) {
                return false;
            } else {
                return true;
            }
        }
        return true;
    }
}
