<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/5 0005
 * Time: 14:39
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model {
    public $timestamps = false;
    public $table = 'log_login';

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
     * 获取登录日志
     */
    public function getLoginLog($pageInfo = null) {
        if ($pageInfo == null) {//没有分页
            $logs = $this
                ->join('admin', 'log_login.adminid', '=', 'admin.id')
                ->select('log_login.*', 'admin.username')
                ->orderBy('logintime', 'desc')
                ->get();
        } else {
            if ($pageInfo['search'] == '') {
                $logs = $this
                    ->join('admin', 'log_login.adminid', '=', 'admin.id')
                    ->select('log_login.*', 'admin.username')
                    ->orderBy('logintime', 'desc')
                    ->offset($pageInfo['start'])
                    ->limit($pageInfo['length'])
                    ->get();
            } else {
                $logs = $this
                    ->join('admin', 'log_login.adminid', '=', 'admin.id')
                    ->whereIn('adminid', $pageInfo['search'])
                    ->select('log_login.*', 'admin.username')
                    ->orderBy('logintime', 'desc')
                    ->offset($pageInfo['start'])
                    ->limit($pageInfo['length'])
                    ->get();
            }
        }
        //转换数据格式
        foreach ($logs as $log) {
            $log->loginipstr = long2ip($log->loginip);
            $log->logintimestr = date("Y/m/d H:i:s", $log->logintime);
        }
        return $logs;
    }

    /**
     * 写入登录日志
     * @param $username
     * @param $status
     * @param $type
     * @param $ip
     */
    public static function writeLoginLog($adminid, $status, $type, $ip) {
        $log = new LoginLog();
        $log->adminid = $adminid;
        $log->status = $status;
        $log->type = $type;
        $log->logintime = time();
        $log->loginip = sprintf('%u', ip2long($ip));
        $log->area = self::getCityByIp($ip);
        $log->save();
    }

    /**
     * 获取Ip地址所在的区域
     * @param $ip ip地址
     * @return string 区域
     */
    private static function getCityByIp($ip) {
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=" . $ip;
        $json = file_get_contents($url);
        if ($json == -1) {
            return '内网地址';
        } else if ($json == -2) {
            return 'ip地址有误';
        } else {
            $address = json_decode($json, true);
            return $address['country'] . $address['province'] . $address['city'];
        }
    }
}