<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/21 0021
 * Time: 10:50
 */

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\Libs\UploadUtils;
use App\OperateLog;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class AdminController {

    //获取分页信息
    private function getPageInfo(Request $request) {
        if (!empty($request->draw)) {
            $pageInfo = [];
            $pageInfo['draw'] = $request->draw;//绘制次数
            $pageInfo['start'] = $request->start;//当前第一条记录的开始处
            $pageInfo['length'] = $request->length;//查询多少条数据
            $pageInfo['search'] = $request->search['value'];
            return $pageInfo;
        }
        return null;
    }

    //列表页面
    public function index($rid = null) {
        if ($rid == null) {
            $rid = 0;
        }
        return view('admin.admin.index', ['rid' => $rid]);
    }

    /**
     * 获取管理员信息
     * @param null $rid
     * @return mixed
     */
    public function getData(Request $request) {
        $pageInfo = $this->getPageInfo($request);
        $rid = $request->rid;
        $adminModel = new Admin();
        if (!is_null($rid)) {
            $admins = $adminModel->getAdmin($rid, $pageInfo);
        } else {
            $admins = $adminModel->getAdmin(0, $pageInfo);
        }
        $count = $adminModel->getAdminCount($rid, $pageInfo);
        return json_encode(
            [
                'draw' => $pageInfo['draw'],
                'recordsTotal' => $count['total'],
                'recordsFiltered' => $count['search'],
                'data' => $admins->toArray()
            ]
        );
    }

    //添加界面
    public function add() {
        $roleModel = new Role();
        $roles = $roleModel->getRole();
        return view('admin.admin.add', ['roles' => $roles]);
    }

    //添加操作
    public function addpost(Request $request) {
        $adminModel = new Admin();
        $validResult = $adminModel->validate($request);
        if (!$validResult['flag']) {
            return error($validResult['msg']);
        }
        $adminModel->rid = $request->rid;
        $adminModel->username = $request->username;
        $adminModel->password = md5($request->password);
        $adminModel->truename = $request->truename;
        $adminModel->email = $request->email;
        $adminModel->telphone = $request->telphone;
        $adminModel->status = $request->status;
        $adminModel->createtime = time();
        //上传头像
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = UploadUtils::getUploadPath($file->guessExtension());
            Image::make($file)->resize(env('PHOTO_WIDTH'), env('PHOTO_HEIGHT'))->save($path);
            $adminModel->photo = $path;
        }
        if ($adminModel->save()) {
            OperateLog::writeLog($request, 1, '添加管理员成功');
            return success("添加成功", '/admin/admin/index', 3);
        } else {
            OperateLog::writeLog($request, 0, '添加管理员失败');
            return error("添加失败");
        }
    }

    //修改页面
    public function edit($id) {
        $roleModel = new Role();
        $roles = $roleModel->getRole();
        $admin = Admin::find($id);
        $roles = $roleModel->setDefaultSelected($roles, $admin->rid);
        return view('admin.admin.edit', ['roles' => $roles, 'admin' => $admin]);
    }

    //修改操作
    public function editpost(Request $request, $id) {
        $adminModel = new Admin();
        $validResult = $adminModel->validate($request, 'edit');
        if (!$validResult['flag']) {
            return error($validResult['msg']);
        }
        $admin = Admin::find($id);
        $admin->rid = $request->rid;
        $admin->username = $request->username;
        if ($request->password != '') {
            $admin->password = md5($request->password);
        }
        $admin->truename = $request->truename;
        $admin->email = $request->email;
        $admin->telphone = $request->telphone;
        $admin->status = $request->status;
        //上传头像
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = UploadUtils::getUploadPath($file->guessExtension());
            Image::make($file)->resize(env('PHOTO_WIDTH'), env('PHOTO_HEIGHT'))->save($path);
            $admin->photo = $path;
        }
        if ($admin->save()) {
            OperateLog::writeLog($request, 1, '修改管理员成功');
            return success("修改成功", '/admin/admin/index', 3);
        } else {
            OperateLog::writeLog($request, 0, '修改管理员失败');
            return error("修改失败");
        }
    }

    //删除操作
    public function del(Request $request, $id) {
        $adminModel = new Admin();
        if ($adminModel->del($id)) {
            OperateLog::writeLog($request, 1, '删除管理员成功');
            return success('删除成功', '/admin/admin/index', 3);
        } else {
            OperateLog::writeLog($request, 0, '删除管理员失败');
            return error('删除失败');
        }
    }

    //个人登录日志界面
    public function loginlog(Request $request) {
        $admin = $request->session()->get('admin');
        $logs = DB::table('log_login')->where('adminid', $admin->id)->orderBy('logintime', 'desc')->get();
        $log = [];
        $looper = [];
        $i = 0;
        foreach ($logs as $v) {
            $date = date('Y/m/d', $v->logintime);
            $log[$date][] = $v;
            if (empty($looper[$date])) {
                $looper[$date] = $i++;
            }
        }
        return view('admin.admin.loginlog', ['logs' => $log, 'looper' => $looper]);
    }

    //个人操作日志界面
    public function operatelog(Request $request) {
        $admin = $request->session()->get('admin');
        $logs = DB::table('operate_log')->where('adminid', $admin->id)->orderBy('time', 'desc')->get();
        $log = [];
        $looper = [];
        $i = 0;
        foreach ($logs as $v) {
            $date = date('Y/m/d', $v->time);
            $log[$date][] = $v;
            if (empty($looper[$date])) {
                $looper[$date] = $i++;
            }
        }
        return view('admin.admin.operatelog', ['logs' => $log, 'looper' => $looper]);
    }

    //发送消息界面
    public function sendmsg(Request $request, $toid) {
        $adminModel = new Admin();
        $fromid = $request->session()->get('admin')->id;
        $receiveiveMsgs = $adminModel->getHistoryMsg($toid, $fromid);
        $sendMsgs = $adminModel->getHistoryMsg($fromid, $toid);
        $msgs = array_merge($receiveiveMsgs->toArray(), $sendMsgs->toArray());
        usort($msgs, [$this, 'sortByTime']);
        $unRead = 0;
        foreach ($msgs as $msg) {
            //判断是不是接收方
            if ($msg->toid == $toid) {
                $msg->send = 1;//设置为接收方
            } else {
                //判断是否未读
                if ($msg->status == 0) {
                    $unRead++;
                }
                $msg->send = 0;//设置为发送方
            }
        }
        return view('admin.admin.sendmsg', ['msgs' => $msgs, 'unRead' => $unRead]);
    }

    //发送消息操作
    public function sendmsgpost(Request $request, $toId) {
        $msg = $request->msg;
        if (empty($msg)) {
            return error('消息内容不能为空');
        }
        $adminModel = new Admin();
        $fromid = $request->session()->get('admin')->id;
        if ($adminModel->saveMsg($fromid, $toId, $msg)) {
            OperateLog::writeLog($request, 1, '消息发送成功');
            return success('消息发送成功', '/admin/admin/sendmsg/' . $toId);
        } else {
            OperateLog::writeLog($request, 0, '消息发送失败');
            return error('消息发送失败');
        }
    }

    //全部消息界面
    public function allmsg(Request $request) {
        $toId = $request->session()->get('admin')->id;
        $adminModel = new Admin();
        $msgs = $adminModel->getAllMsg($toId);
        $msg = [];
        $looper = [];
        $i = 0;
        foreach ($msgs as $v) {
            $date = date('Y/m/d', $v->createtime);
            $msg[$date][] = $v;
            if (empty($looper[$date])) {
                $looper[$date] = $i++;
            }
        }
        return view('admin.admin.allmsg', ['msgs' => $msg, 'looper' => $looper]);
    }

    //把消息标记为已读
    public function read(Request $request, $id) {
        if (DB::table('admin_msg')->where('id', $id)->update(['status' => 1])) {
            OperateLog::writeLog($request, 1, '消息已读标识设置成功');
            return success('设置成功', '/admin/admin/allmsg');
        }
        OperateLog::writeLog($request, 0, '消息已读标识设置失败');
        return error('设置失败');
    }

    //把所有消息标记为已读
    public function readAll(Request $request) {
        $toId = $request->session()->get('admin')->id;
        if (DB::table('admin_msg')->where(['toid' => $toId, 'status' => 0])->update(['status' => 1])) {
            OperateLog::writeLog($request, 1, '全部消息已读标识设置成功');
            return success('设置成功', '/admin/admin/allmsg');
        }
        OperateLog::writeLog($request, 0, '全部消息已读标识设置失败');
        return error('设置失败');
    }

    //删除消息
    public function delmsg(Request $request, $id) {
        if (DB::table('admin_msg')->where('id', $id)->delete()) {
            OperateLog::writeLog($request, 1, '消息删除成功');
            return success('删除成功', '/admin/admin/allmsg');
        }
        OperateLog::writeLog($request, 0, '消息删除失败');
        return error('删除失败');
    }


    /**
     * 自定义比较函数
     * @param $a 数组A
     * @param $b 数组B
     * @return int 比较结果
     */
    private function sortByTime($a, $b) {
        if ($a->createtime == $b->createtime) {
            return 0;
        }
        return $a->createtime < $b->createtime ? -1 : 1;
    }

}