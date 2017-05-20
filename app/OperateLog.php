<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/6 0006
 * Time: 9:03
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OperateLog extends Model {

    public $timestamps = false;
    public $table = 'operate_log';

    /**
     * 获取系统配置的个数
     * @param int $rid
     * @param null $pageInfo
     */
    public function getCount($pageInfo = null) {
        $count = [];
        $count['total'] = $this->count();
        if ($pageInfo['search'] == '') {
            $count['search'] = $count['total'];
        } else {
            $count['search'] = $this->whereIn('adminid', $pageInfo['search'])->count();
        }
        return $count;
    }

    /**
     * 获取所有操作日志
     * @return mixed
     */
    public function getOperateLog($pageInfo = null) {
        if ($pageInfo == null) {//没有分页
            $logs = $this
                ->leftJoin('admin', 'operate_log.adminid', '=', 'admin.id')
                ->select('operate_log.*', 'admin.username')
                ->orderBy('time', 'desc')
                ->get();
        } else {
            if ($pageInfo['search'] == '') {
                $logs = $this
                    ->leftJoin('admin', 'operate_log.adminid', '=', 'admin.id')
                    ->select('operate_log.*', 'admin.username')
                    ->orderBy('time', 'desc')
                    ->offset($pageInfo['start'])
                    ->limit($pageInfo['length'])
                    ->get();
            } else {
                $logs = $this
                    ->leftJoin('admin', 'operate_log.adminid', '=', 'admin.id')
                    ->whereIn('adminid', $pageInfo['search'])
                    ->select('operate_log.*', 'admin.username')
                    ->orderBy('time', 'desc')
                    ->offset($pageInfo['start'])
                    ->limit($pageInfo['length'])
                    ->get();
            }
        }
        //转换数据格式
        foreach ($logs as $log) {
            $log->timestr = date("Y/m/d H:i:s", $log->time);
        }
        return $logs;
    }

    /**
     * 写入操作日志
     * @param $request Request对象
     * @param $status 是否成功
     * @param $description 操作描述
     */
    public static function writeLog(Request $request, $status, $description) {
        $log = new OperateLog();
        $log->adminid = $request->session()->get('admin')->id;
        $log->url = $request->getPathInfo();
        $log->method = $request->method();
        $log->status = $status;
        $log->description = $description;
        $log->time = time();
        $log->save();
    }

}