<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/5 0005
 * Time: 14:38
 */

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\LoginLog;
use App\OperateLog;
use Illuminate\Http\Request;

class LogController {

    //登录日志列表页面
    public function loginlog() {
        return view('admin.log.loginlog');
    }

    //获取分页信息
    private function getPageInfo(Request $request) {
        if (!empty($request->draw)) {
            $pageInfo = [];
            $pageInfo['draw'] = $request->draw;//绘制次数
            $pageInfo['start'] = $request->start;//当前第一条记录的开始处
            $pageInfo['length'] = $request->length;//查询多少条数据
            $username = $request->search['value'];
            $adminModel = new Admin();
            $pageInfo['search'] = $adminModel->searchByUsername($username);
            return $pageInfo;
        }
        return null;
    }

    //获取登录日志数据
    public function getLoginData(Request $request) {
        $pageInfo = $this->getPageInfo($request);//获取分页信息
        $logModel = new LoginLog();
        $logs = $logModel->getLoginLog($pageInfo);//获取登录数据
        $count = $logModel->getCount($pageInfo);//获取记录数
        return json_encode(
            [
                'draw' => $pageInfo['draw'],
                'recordsTotal' => $count['total'],
                'recordsFiltered' => $count['search'],
                'data' => $logs->toArray()
            ]
        );
    }

    //删除登录日志操作
    public function del($id) {
        $log = LoginLog::find($id);
        if ($log->delete()) {
            return success('删除成功', '/admin/log/loginlog');
        } else {
            return error('删除失败');
        }
    }

    //操作日志列表页面
    public function operatelog() {
        return view('admin.log.operatelog');
    }

    public function getOperateData(Request $request) {
        $pageInfo = $this->getPageInfo($request);//获取分页信息
        $logModel = new OperateLog();
        $logs = $logModel->getOperateLog($pageInfo);//获取登录数据
        $count = $logModel->getCount($pageInfo);//获取记录数
        return json_encode(
            [
                'draw' => $pageInfo['draw'],
                'recordsTotal' => $count['total'],
                'recordsFiltered' => $count['search'],
                'data' => $logs->toArray()
            ]
        );

    }

    //删除操作日志操作
    public function deloperate($id) {
        $log = OperateLog::find($id);
        if ($log->delete()) {
            return success('删除成功', '/admin/log/operatelog');
        } else {
            return error('删除失败');
        }
    }

}