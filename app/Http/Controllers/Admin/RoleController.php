<?php
/**
 * 角色控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/21 0021
 * Time: 17:40
 */

namespace App\Http\Controllers\Admin;

use App\OperateLog;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoleController {

    //显示角色信息
    public function index() {
        return view('admin.role.index');
    }

    //获取角色信息
    public function getData() {
        $roleModel = new Role();
        $roles = $roleModel->getRole();
        return json_encode(['data' => $roles]);
    }

    //添加界面
    public function add() {
        $roleModel = new Role();
        $roles = $roleModel->getRole();
        return view('admin.role.add', ['roles' => $roles]);
    }

    //添加操作
    public function addpost(Request $request) {
        $role = new Role();
        $role->parentid = $request->parentid;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->status = $request->status;
        $role->createtime = time();
        $role->sort = $request->sort;
        if ($role->save()) {
            //添加角色权限
            if ($role->parentIsSuper($role->id)) {
                $role->addSuperPerm($role->id);
            } else {
                $role->addParentPerm($role->id);
            }
            OperateLog::writeLog($request, 1, '添加角色成功');
            return success('添加成功', '/admin/role/index', 3);
        } else {
            OperateLog::writeLog($request, 0, '添加角色失败');
            return error('添加失败');
        }
    }

    //修改界面
    public function edit($id) {
        $roleModel = new Role();
        $roles = $roleModel->getEditRole($id);
        $role = Role::find($id);
        $roles = $roleModel->setDefaultSelected($roles, $role->parentid);
        return view('admin.role.edit', ['roles' => $roles, 'role' => $role]);
    }

    //修改操作
    public function editpost(Request $request, $id) {
        $role = Role::find($id);
        $role->parentid = $request->parentid;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->status = $request->status;
        $role->createtime = time();
        $role->sort = $request->sort;
        if ($role->save()) {
            $role->delPermByRole($id);//删除所有权限
            //添加角色权限
            if ($role->parentIsSuper($role->id)) {
                $role->addSuperPerm($role->id);
            } else {
                $role->addParentPerm($role->id);
            }
            OperateLog::writeLog($request, 1, '修改角色成功');
            return success('修改成功', '/admin/role/index', 3);
        } else {
            OperateLog::writeLog($request, 0, '修改角色失败');
            return error('修改失败');
        }
    }

    //删除操作
    public function del(Request $request, $id) {
        $roleModel = new Role();
        //如果有子角色
        if ($roleModel->hasChildRole($id)) {
            return error('该角色下有子角色，不能删除该角色');
        }
        //如果该角色下有管理员
        if ($roleModel->hasAdmin($id)) {
            return error('该角色下有管理员，不能删除该角色');
        }
        $role = Role::find($id);
        if ($role->delete()) {
            DB::table('role_perm')->where('rid', $id)->delete();//删除角色的权限
            OperateLog::writeLog($request, 1, '删除角色成功');
            return success('删除成功', '/admin/role/index', 3);
        } else {
            OperateLog::writeLog($request, 0, '删除角色失败');
            return success('删除失败');
        }
    }

    //授权页面
    public function access($id) {
        $roleModel = new Role();
        $perms = $roleModel->getRolePerm($id);
        return view('admin.role.access', ['perms' => $perms, 'roleId' => $id]);
    }

    //授权提交
    public function accessAdd(Request $request) {
        $roleId = $request->roleId;
        $permIds = $request->permIds;
        $roleModel = new Role();
        OperateLog::writeLog($request, 1, '角色授权成功');
        $roleModel->delPermByRole($roleId);//删除已有的权限
        $roleModel->addPermByRole($roleId, $permIds);//添加权限
        return json_encode(["status" => 200, "msg" => "授权成功"]);
    }

}