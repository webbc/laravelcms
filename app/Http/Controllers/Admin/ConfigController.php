<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/3 0003
 * Time: 20:33
 */

namespace App\Http\Controllers\Admin;


use App\Config;
use App\OperateLog;
use Illuminate\Http\Request;

class ConfigController {

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

    //系统配置页面
    public function system() {
        return view('admin.config.system');
    }

    //获取系统配置数据
    public function getSystemData(Request $request) {
        $pageInfo = $this->getPageInfo($request);//获取分页信息

        $configModel = new Config();
        $configs = $configModel->getConfig($pageInfo);//获取
        $count = $configModel->getCount($pageInfo);//获取系统配置的记录数
        return json_encode(
            [
                'draw' => $pageInfo['draw'],
                'recordsTotal' => $count['total'],
                'recordsFiltered' => $count['search'],
                'data' => $configs->toArray()
            ]
        );
    }

    //修改系统配置操作
    public function systemedit(Request $request) {
        $configModel = new Config();
        $id = $request->id;
        $value = $request->value;
        $configModel->editSystemConfig($id, $value);
        OperateLog::writeLog($request, 1, '修改系统配置成功');
        return json_encode(['flag' => 200, 'msg' => '修改配置成功']);
    }

    //扩展配置界面
    public function extend() {
        return view('admin.config.extend');
    }

    //获取扩展配置数据
    public function getExtendData(Request $request) {
        $pageInfo = $this->getPageInfo($request);//获取分页信息
        $configModel = new Config();
        $configs = $configModel->getConfig($pageInfo, 1);
        $count = $configModel->getCount($pageInfo, 1);//获取系统配置的记录数
        return json_encode(
            [
                'draw' => $pageInfo['draw'],
                'recordsTotal' => $count['total'],
                'recordsFiltered' => $count['search'],
                'data' => $configs->toArray()
            ]
        );
    }

    //添加扩展配置界面
    public function add() {
        return view('admin.config.add');
    }

    //添加操作
    public function addpost(Request $request) {
        $config = new Config();
        if (($error = $config->validate($request->all())) !== true) {
            return error($error);
        }
        $config->varname = $request->varname;
        $config->info = $request->info;
        $config->value = $request->value;
        $config->type = $request->type;
        $config->classify = 1;
        if ($config->save()) {
            OperateLog::writeLog($request, 1, '添加扩展配置成功');
            return success('添加成功', '/admin/config/extend');
        } else {
            OperateLog::writeLog($request, 0, '添加扩展配置失败');
            return error('添加失败');
        }
    }

    //修改页面
    public function edit($id) {
        $config = Config::find($id);
        return view('admin.config.edit', ['config' => $config]);
    }

    //修改操作
    public function editpost(Request $request, $id) {
        $config = Config::find($id);
        if (($error = $config->validate($request->all())) !== true) {
            return error($error);
        }
        $config->varname = $request->varname;
        $config->info = $request->info;
        $config->value = $request->value;
        $config->type = $request->type;
        $config->classify = 1;
        if ($config->save()) {
            OperateLog::writeLog($request, 1, '修改扩展配置成功');
            return success('修改成功', '/admin/config/extend');
        } else {
            OperateLog::writeLog($request, 0, '修改扩展配置失败');
            return error('修改失败');
        }
    }

    //删除操作
    public function del(Request $request, $id) {
        $config = Config::find($id);
        if ($config->delete()) {
            OperateLog::writeLog($request, 1, '删除扩展配置成功');
            return success('删除成功', '/admin/config/extend');
        } else {
            OperateLog::writeLog($request, 0, '删除扩展配置失败');
            return error('删除失败');
        }
    }
}