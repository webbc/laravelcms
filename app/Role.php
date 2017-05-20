<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model {

    protected $table = 'role';

    public $timestamps = false;

    /**
     * 设置默认select框选中某个角色
     * @param $roles所有角色
     * @param $rid选中角色id
     * @return array 角色数组
     */
    public function setDefaultSelected($roles, $rid) {
        foreach ($roles as $k => $v) {
            if ($v->id == $rid) {
                $roles[$k]->selected = "selected = selected";
            } else {
                $roles[$k]->selected = "";
            }
        }
        return $roles;
    }

    /**
     * 递归获取角色树
     * @return array 角色数组
     */
    public function getRole($id = 0, $deep = 0) {
        static $tempArr = [];
        $roles = $this->where('parentid', $id)->orderBy('sort')->get();
        foreach ($roles as $k => $v) {
            $v->createtimestr = date('Y/m/d H:i:s', $v->createtime);
            $v->deep = $deep;
            $v->name = str_repeat("&nbsp;&nbsp;", $v->deep * 2) . "|--" . $v->name;
            $tempArr[] = $v;
            $this->getRole($v->id, $deep + 1);
        }
        return $tempArr;
    }

    /**
     * 获取修改时的角色树
     * @param int $id
     * @param int $deep
     * @return array
     */
    public function getEditRole($except = -1, $id = 0, $deep = 0) {
        static $temp = [];
        $roles = $this->where('parentid', $id)->orderBy('sort')->get();
        foreach ($roles as $k => $v) {
            if ($v->id == $except) {
                continue;
            }
            $v->deep = $deep;
            $v->name = str_repeat("&nbsp;&nbsp;", $v->deep * 2) . "|--" . $v->name;
            $temp[] = $v;
            $this->getEditRole($except, $v->id, $deep + 1);
        }
        return $temp;
    }

    /**
     * 获取指定角色设置的权限树
     * @param $roleId 角色id
     * @return array 权限
     */
    public function getRolePerm($rid) {
        $allPerms = $this->getAllPerm();//获取所有权限
        //获取可设置的权限
        $enablePerms = DB::table("role_perm")->select('pid')->where('rid', $rid)->get();
        $permIds = [];//可设置的权限数组
        foreach ($enablePerms as $perm) {
            $permIds[] = $perm->pid;
        }
        foreach ($allPerms as $v) {
            if ($v->parentid == 0) {
                $v->open = "true";
            }
            if (!in_array($v->id, $permIds)) {
                $v->chkDisabled = "true";
                $v->checked = "false";
            } else {
                $v->checked = "true";
            }
        }
        return $allPerms;
    }

    /**
     * 获取所有的权限
     * @return array 权限数组
     */
    public function getAllPerm() {
        return DB::table('perm')->select('id', 'parentid', 'name')->where('status', 1)->orderBy('sort')->get();
    }

    /**
     * 判断父级角色是否是超级管理员
     * @param $rid
     */
    public function parentIsSuper($rid) {
        $role = $this->find($rid);
        $parentRole = $this->where('id', $role->parentid)->first();
        if ($parentRole->parentid == 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 添加超级管理员子角色拥有的权限
     */
    public function addSuperPerm($rid) {
        $perms = $this->getAllPerm();
        $permIds = [];
        foreach ($perms as $perm) {
            $permIds[] = $perm->id;
        }
        $this->addPermByRole($rid, $permIds);
    }

    /**
     * 添加父级角色的权限
     * @param $rid
     */
    public function addParentPerm($rid) {
        $role = $this->find($rid);
        $parentRole = $this->where('id', $role->parentid)->first();
        $perms = DB::table('role_perm')->select('pid')->where('rid', $parentRole->id)->get();
        $permIds = [];
        foreach ($perms as $perm) {
            $permIds[] = $perm->pid;
        }
        $this->addPermByRole($rid, $permIds);
    }

    /**
     * 添加角色的权限
     * @param $roleId 角色id
     * @param $permIds 权限数组
     * @return string 授权成功消息
     */
    public function addPermByRole($roleId, $permIds) {
        foreach ($permIds as $v) {
            DB::table('role_perm')->insert(['rid' => $roleId, 'pid' => $v]);
        }
    }

    /**
     * 删除指定角色的所有权限
     * @param $roleId 角色id
     * @return boolean 删除标识
     */
    public function delPermByRole($roleId) {
        return DB::table("role_perm")->where("rid", $roleId)->delete();
    }

    /**
     * 判断指定角色下是否还有角色
     * @param $rid 角色id
     */
    public function hasChildRole($rid) {
        $count = $this->where('parentid', $rid)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断指定角色下是否有管理员
     * @param $rid 角色id
     */
    public function hasAdmin($rid) {
        $count = DB::table('admin')->where('rid', $rid)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

}
