<?php
/**
 * 栏目模块
 * User: Administrator
 * Date: 2017/4/29 0029
 * Time: 9:59
 */

namespace App\Http\Controllers\Admin;

use App\Column;
use App\Libs\UploadUtils;
use App\OperateLog;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ClassController {

    //列表页面
    public function index() {
        return view('admin.class.index');
    }

    //获取所有栏目
    public function getData() {
        $classModel = new Column();
        $classs = $classModel->getClass();
        return json_encode(['data' => $classs]);
    }

    //添加页面
    public function add() {
        $classModel = new Column();
        $classs = $classModel->getClass();
        $tpls = $classModel->getConverTpl();
        return view('admin.class.add', ['classs' => $classs, 'tpls' => $tpls]);
    }

    //添加操作
    public function addpost(Request $request) {
        //自动验证
        $class = new Column();
        if (($error = $class->validate($request->all())) !== true) {
            return error($error);
        }
        $class->parentid = $request->parentid;
        $class->name = $request->name;
        $class->covertplid = $request->covertplid;
        $class->description = $request->description;
        $class->url = $request->url;
        $class->isnav = $request->isnav;
        $class->status = $request->status;
        $class->sort = $request->sort;
        $class->createtime = time();
        //上传缩略图
        if ($request->hasFile('thumb')) {
            $file = $request->file('thumb');
            $path = UploadUtils::getUploadPath($file->guessExtension());
            Image::make($file)->resize(env('THUMB_WIDTH'), env('THUMB_HEIGHT'))->save($path);
            $class->thumb = $path;
        }
        if ($class->save()) {
            if (!empty($request->input('content'))) {
                $class->addClassContent($class->id, $request->input('content'));
            }
            OperateLog::writeLog($request, 1, '添加栏目成功');
            return success('添加成功', '/admin/class/index');
        } else {
            OperateLog::writeLog($request, 0, '添加栏目失败');
            return error('添加失败');
        }
    }

    //修改界面
    public function edit($id) {
        $classModel = new Column();
        $classs = $classModel->getEditClass($id);
        $tpls = $classModel->getConverTpl();
        $class = Column::find($id);
        $content = $class->readClassContent($id);
        return view('admin.class.edit', ['classs' => $classs, 'tpls' => $tpls, 'class' => $class, 'content' => $content]);
    }

    //修改操作
    public function editpost(Request $request, $id) {
        //自动验证
        $class = Column::find($id);
        if (($error = $class->validate($request->all())) !== true) {
            return error($error);
        }
        $class->parentid = $request->parentid;
        $class->name = $request->name;
        $class->covertplid = $request->covertplid;
        $class->description = $request->description;
        $class->url = $request->url;
        $class->isnav = $request->isnav;
        $class->status = $request->status;
        $class->sort = $request->sort;
        //上传缩略图
        if ($request->hasFile('thumb')) {
            $file = $request->file('thumb');
            $path = UploadUtils::getUploadPath($file->guessExtension());
            Image::make($file)->resize(env('THUMB_WIDTH'), env('THUMB_HEIGHT'))->save($path);
            $class->thumb = $path;
        }
        if ($class->save()) {
            if (!empty($request->input('content'))) {
                $class->updateClassContent($id, $request->input('content'));
            }
            OperateLog::writeLog($request, 1, '修改栏目成功');
            return success('修改成功', '/admin/class/index');
        } else {
            OperateLog::writeLog($request, 0, '修改栏目失败');
            return error('修改失败');
        }
    }

    //删除操作
    public function del(Request $request, $id) {
        $classModel = new Column();
        //如果有子栏目
        if ($classModel->hasChildClass($id)) {
            return error('该栏目下有子栏目，不能删除该栏目');
        }
        //如果该栏目下有文章
        if ($classModel->hasArticle($id)) {
            return error('该栏目下有文章，不能删除该栏目');
        }
        $class = Column::find($id);
        if ($class->delete()) {
            OperateLog::writeLog($request, 1, '删除栏目成功');
            return success('删除成功', '/admin/class/index', 3);
        } else {
            OperateLog::writeLog($request, 0, '删除栏目失败');
            return success('删除失败');
        }
    }

}