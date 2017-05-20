<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/21 0021
 * Time: 17:07
 */

namespace App\Libs;

use Illuminate\Support\Facades\DB;


class ServerUtils {
    /**
     * 获取服务器配置信息
     * @return array 服务器配置
     */
    public static function getServerInfo() {
        return array(
            'pc' => $_SERVER['SERVER_NAME'], //当前主机名
            'os' => $_SERVER["SERVER_SOFTWARE"], //获取服务器标识的字串
            'php_version' => PHP_VERSION, //获取PHP服务器版本
            'time' => date("Y-m-d H:i:s", time()), //获取服务器时间
            'osname' => php_uname(), //获取系统类型及版本号
            'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'], //获取服务器语言
            'port' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
            'max_upload' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", //最大上传
            'max_ex_time' => ini_get("max_execution_time") . "秒", //脚本最大执行时间
            'mysql_version' => self::getMysqlVersion(), //获取服务器MySQL版本
            'mysql_size' => self::getMysqlSize(), //获取服务器Mysql已使用大小
        );
    }

    /**
     * 获取服务器MySQL版本信息
     * @return string
     */
    private static function getMysqlVersion() {
        $version = DB::select( "select version() as ver" );
        return $version[0]->ver;
    }

    /**
     * 获取服务器MySQL大小
     * @return string
     */
    private static function getMysqlSize() {
        $sql = "SHOW TABLE STATUS FROM " . env ( 'DB_DATABASE' );
        $tblPrefix = config('connections.mysql.prefix');
        if ($tblPrefix != null) {
            $sql .= " LIKE '{$tblPrefix}%'";
        }
        $row = DB::select( $sql );
        $size = 0;
        foreach ( $row as $value ) {
            $size += $value->Data_length + $value->Index_length;
        }
        return round ( ($size / 1048576), 2 ) . 'M';
    }
}