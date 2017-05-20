<?php

/**
 * 管理员模型
 */
namespace App;

use App\Libs\Verify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Admin extends Model {

    public $table = "admin";
    public $timestamps = false;

    /**
     * 获取管理员的个数
     * @param int $rid
     * @param null $pageInfo
     */
    public function getAdminCount($rid = 0, $pageInfo = null) {
        $count = [];
        if ($rid == 0) {//不存在指定角色，查询所有
            $count['total'] = $this->count();
            if ($pageInfo['search'] == '') {
                $count['search'] = $count['total'];
            } else {
                $count['search'] = $this->where('username', 'like', "%{$pageInfo['search']}%")->count();
            }
        } else {//查询指定角色下的管理员
            $count['total'] = $this->where('rid', $rid)->count();
            if ($pageInfo['search'] == '') {
                $count['search'] = $count['total'];
            } else {
                $count['search'] = $this->where('rid', $rid)->where('username', 'like', "%{$pageInfo['search']}%")->count();
            }
        }
        return $count;
    }

    /**
     * 获取管理员
     * @param int $rid 指定角色
     * @return array 管理员数组
     */
    public function getAdmin($rid = 0, $pageInfo = null) {
        if ($rid == 0) {//不存在指定角色，查询所有
            if ($pageInfo == null) {//没有分页
                $admins = $this->get();
            } else {
                if ($pageInfo['search'] == '') {
                    $admins = $this->offset($pageInfo['start'])->limit($pageInfo['length'])->get();
                } else {
                    $admins = $this->where('username', 'like', "%{$pageInfo['search']}%")->offset($pageInfo['start'])->limit($pageInfo['length'])->get();
                }
            }
        } else {//查询指定角色下的管理员
            if ($pageInfo == null) {//没有分页
                $admins = $this->where('rid', $rid)->get();
            } else {
                if ($pageInfo['search'] == '') {
                    $admins = $this->where('rid', $rid)->offset($pageInfo['start'])->limit($pageInfo['length'])->get();
                } else {
                    $admins = $this->where('username', 'like', "%{$pageInfo['search']}%")->where('rid', $rid)->offset($pageInfo['start'])->limit($pageInfo['length'])->get();
                }
            }
        }
        //转换数据格式
        foreach ($admins as $admin) {
            $admin->loginipstring = long2ip($admin->lastloginip);
            $admin->logintimestring = date("Y/m/d H:i:s", $admin->lastlogintime);
        }
        return $admins;
    }

    /**
     * 判断用户名是否存在
     * @param $username 管理员名称
     * @return bool 存在标识
     */
    private function isUsernameExist($username) {
        if ($this->where("username", $username)->first()) {
            return true;
        }
        return false;
    }

    /**
     * 判断邮箱是否存在
     * @param $email 邮箱
     * @return bool 存在标识
     */
    private function isEmailExist($email) {
        if ($this->where("email", $email)->first()) {
            return true;
        }
        return false;
    }

    /**
     * 验证数据是否合法
     * @param Request $request Request对象
     * @return array 验证结果
     */
    public function validate(Request $request, $action = 'add') {
        if (!Verify::checkName($request->username)) {
            return ['flag' => false, 'msg' => '用户名格式不正确'];
        }
        if (!Verify::checkEmail($request->email)) {
            return ['flag' => false, 'msg' => '邮箱格式不正确'];
        }
        if (!Verify::isMobile($request->telphone)) {
            return ['flag' => false, 'msg' => '手机格式不正确'];
        }
        if ($action == 'add') {
            if (!Verify::isPWD($request->password) || !Verify::isPWD($request->repassword)) {
                return ['flag' => false, 'msg' => '密码格式不正确'];
            }
            if ($this->isUsernameExist($request->username)) {
                return ['flag' => false, 'msg' => '用户名已存在'];
            }
            if ($this->isEmailExist($request->email)) {
                return ['flag' => false, 'msg' => '邮箱已存在'];
            }
        }
        if ($request->password != $request->repassword) {
            return ['flag' => false, 'msg' => '两次密码不一致'];
        }
        if (!Role::find($request->rid)) {
            return ['flag' => false, 'msg' => '所属角色不存在'];
        }
        return ['flag' => true];
    }

    /**
     * 删除管理员
     * @param $id 管理员编号
     */
    public function del($id) {
        $admin = $this->find($id);
        return $admin->delete();
    }

    /**
     * 登录
     * @param $username 用户名
     * @param $password 密码
     * @return array 管理员数组
     */
    public function login($username, $password) {
        $pattern = "/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/";
        $pregResult = preg_match($pattern, $username);
        if ($pregResult != false && $pregResult == 1) {
            $where = 'email';
        } else {
            $where = 'username';
        }
        $admin = $this->where([$where => $username, 'password' => md5($password)])->first();
        $type = $where == 'email' ? 0 : 1;
        return array($admin, $type);
    }

    /**
     * 设置登录数据
     * @param $admin 管理员id
     * @param Request $request Request对象
     */
    public function setLoginInfo($id, Request $request) {
        $admin = $this->find($id);
        $admin->lastloginip = sprintf("%u", ip2long($request->getClientIp()));
        $admin->lastlogintime = time();
        $admin->islogin = 1;
        $admin->save();
    }

    /**
     * 获取发送的历史消息
     * @param $fromid 发送者的id
     * @param $toid 接收者的id
     * @return array 消息数组
     */
    public function getHistoryMsg($fromid, $toid) {
        return DB::table('admin_msg')
            ->join('admin as t1', 'admin_msg.fromid', '=', 't1.id')
            ->select('admin_msg.*', 't1.username as fromUsername', 't1.photo as fromPhoto')
            ->where(['fromid' => $fromid, 'toid' => $toid])
            ->orderBy('createtime')
            ->get();
    }

    /**
     * 获取未读信息
     * @param $fromId 接收者
     * @return mixed
     */
    public function getUnReadMsg($toId) {
        return DB::table('admin_msg')
            ->join('admin as t1', 'admin_msg.fromid', '=', 't1.id')
            ->select('admin_msg.*', 't1.username as fromUsername', 't1.photo as fromPhoto')
            ->where(['toid' => $toId, 'admin_msg.status' => 0])
            ->orderBy('createtime', 'desc')
            ->get();
    }

    /**
     * 保存消息
     * @param $fromId 发送人
     * @param $toId 接收人
     * @param $msg 消息内容
     * @return bool 保存是否成功
     */
    public function saveMsg($fromId, $toId, $msg) {
        if (DB::table('admin_msg')->insert(['fromid' => $fromId, 'toid' => $toId, 'msg' => $msg, 'createtime' => time()])) {
            return true;
        }
        return false;
    }

    /**
     * 获取所有消息
     * @param $toId
     * @return mixed
     */
    public function getAllMsg($toId) {
        return DB::table('admin_msg')
            ->join('admin as t1', 'admin_msg.fromid', '=', 't1.id')
            ->select('admin_msg.*', 't1.username as fromUsername', 't1.photo as fromPhoto')
            ->where(['toid' => $toId])
            ->orderBy('createtime', 'desc')
            ->get();
    }

    /**
     * 根据用户名模糊查找
     * @param $username 用户名
     */
    public function searchByUsername($username) {
        $admins = $this->select('id')->where('username', 'like', "%$username%")->get();
        $ids = [];
        foreach ($admins as $admin) {
            $ids[] = $admin->id;
        }
        return $ids;
    }
}
