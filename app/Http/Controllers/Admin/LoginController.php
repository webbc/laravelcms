<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26 0026
 * Time: 20:58
 */

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\LoginLog;
use App\Role;
use Illuminate\Http\Request;

class LoginController {

    //登录界面
    public function login() {
        return view('admin.login.login');
    }

    //登录操作
    public function loginpost(Request $request) {
        $username = $request->username;
        $password = $request->password;
        $adminModel = new Admin();
        $result = $adminModel->login($username, $password);
        if (($admin = $result[0]) != false) {
            if ($admin->status == 0) {
                return error('该用户已被禁用，请联系管理员');
            }
            $role = Role::find($admin->rid);
            if ($role->status == 0) {
                return error('该用户所属的角色组已被禁用，请联系管理员');
            }
            LoginLog::writeLoginLog($admin->id, 1, $result[1], $request->ip());//写入日志
            $adminModel->setLoginInfo($admin->id, $request);//写入登录数据
            $request->session()->put('admin', $admin);//写入session
            return redirect('/admin/dashboard/index');//跳转至后台首页
        }
        return error('用户名或密码错误');
    }

    //注销登录
    public function loginout(Request $request, $id) {
        //修改登录状态
        $admin = Admin::find($id);
        $admin->islogin = 0;
        $admin->save();
        //清空session
        $request->session()->remove('admin');
        return redirect('/admin/login/login');
    }
}