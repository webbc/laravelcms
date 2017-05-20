<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2 0002
 * Time: 17:34
 */

namespace App\Libs;


class UploadUtils {
    /**
     * 随机的文件名
     * @param int $len 随机文件名的长度
     * @return str 随机字符串
     */
    private static function randName($len = 10) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234565789'), 0, $len);
    }

    /**
     * 创建文件上传到的路径
     * @return str 文件上传的路径
     */
    private static function createDir() {
        $dir = env('UPLOADPATH') . date('Ymd', time());
        if (is_dir($dir) || mkdir($dir, 0777, true)) {
            return $dir;
        }
    }

    /**
     * 获取上传文件的路径
     * @return str 文件的全路径
     */
    public static function getUploadPath($ext = 'jpg') {
        return self::createDir() . '/' . self::randName() . '.' . $ext;
    }

}