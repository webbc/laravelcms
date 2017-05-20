<?php
/**
 * 检测后台用户是否有执行对应操作权限
 * User: Administrator
 * Date: 2017/5/6 0006
 * Time: 11:02
 */

namespace App\Http\Middleware;

use App\Perm;
use Closure;


class CheckAdminPerm {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //检测登录用户所在的角色组是否有权限
        $rid = $request->session()->get('admin')->rid;
        $permModel = new Perm();
        if (!$permModel->checkAdminPerm($rid, $request->getPathInfo())) {
            return response()
                ->view('common.jump',
                    ['message' => '你没有权限操作', 'url' => '', 'jumpTime' => 3]
                );
        }
        return $next($request);
    }
}