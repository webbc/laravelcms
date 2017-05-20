<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Column extends Model {
    public $table = 'class';
    public $timestamps = false;

    private $rules = [
        'parentid' => 'required|integer',
        'name' => 'required|max:20',
        'description' => 'nullable|max:255',
        'covertplid' => 'required|integer|not_in:-1',
        'url' => 'nullable|url',
        'isnav' => 'required|in:0,1',
        'status' => 'required|in:0,1',
        'sort' => 'required|integer',
        'content' => 'string'
    ];

    private $messages = [
        'required' => ':attribute不能为空',
        'integer' => ':attribute必须是数字',
        'not_in' => '请选择:attribute',
        'max' => ':attribute超过了最大范围',
        'url' => ':attribute必须是一个URL',
        'string' => ':attribute必须是字符'
    ];

    private $attribute = [
        'parentid' => '父级栏目',
        'name' => '栏目名称',
        'covertplid' => '模板',
        'url' => '外部链接',
        'isnav' => '是否在导航显示',
        'status' => '状态',
        'sort' => '排序',
        'content' => '栏目内容'
    ];

    /**
     * 递归获取角色树
     * @return array 角色数组
     */
    public function getClass($id = 0, $deep = 0) {
        static $tempArr = [];
        $classs = $this->join('cover_tpl', 'class.covertplid', 'cover_tpl.id')->select('class.*', 'cover_tpl.name as tpl')->where('parentid', $id)->orderBy('class.sort')->get();
        foreach ($classs as $k => $v) {
            $v->createtimestr = date('Y/m/d H:i:s', $v->createtime);
            $v->deep = $deep;
            $v->name = str_repeat("&nbsp;&nbsp;", $v->deep * 2) . "|--" . $v->name;
            $tempArr[] = $v;
            $this->getClass($v->id, $deep + 1);
        }
        return $tempArr;
    }

    /**
     * 递归修改时获取角色树
     * @return array 角色数组
     */
    public function getEditClass($except = -1, $id = 0, $deep = 0) {
        static $tempArr = [];
        $classs = $this->join('cover_tpl', 'class.covertplid', 'cover_tpl.id')->select('class.*', 'cover_tpl.name as tpl')->where('parentid', $id)->orderBy('class.sort')->get();
        foreach ($classs as $k => $v) {
            if ($v->id == $except) {
                continue;
            }
            $v->deep = $deep;
            $v->name = str_repeat("&nbsp;&nbsp;", $v->deep * 2) . "|--" . $v->name;
            $tempArr[] = $v;
            $this->getEditClass($except, $v->id, $deep + 1);
        }
        return $tempArr;
    }

    /**
     * 获取所有封面模板
     * @return array 模板数据
     */
    public function getConverTpl() {
        return DB::table('cover_tpl')->get();
    }

    /**
     * 自动验证
     * @params 表单数据
     * @return object/bool 验证成功/失败
     */
    public function validate($data) {
        $validator = Validator::make($data, $this->rules, $this->messages, $this->attribute);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        return true;
    }

    /**
     * 判断栏目内容是否存在
     * @param $id 栏目id
     * @return bool 是否存在
     */
    public function isContentExist($id) {
        if (DB::table('class_detail')->where('cid', $id)->first()) {
            return true;
        } else {
            false;
        }
    }

    /**
     * 添加栏目内容
     * @param $id 栏目id
     * @param $content 内容
     */
    public function addClassContent($id, $content) {
        DB::table('class_detail')->insert(['cid' => $id, 'content' => $content]);
    }

    /**
     * 读取栏目内容
     * @param $id
     * @return string 栏目内容
     */
    public function readClassContent($id) {
        if ($this->isContentExist($id)) {
            $content = DB::table('class_detail')->select('content')->where('cid', $id)->first()->content;
            return $content;
        }
        return '';
    }

    /**
     * 修改栏目内容
     * @param $id
     * @param $content
     */
    public function updateClassContent($id, $content) {
        if ($this->isContentExist($id)) {
            DB::table('class_detail')->where('cid', $id)->update(['content' => $content]);
        } else {
            $this->addClassContent($id, $content);
        }
    }

    /**
     * 判断指定栏目下是否还有栏目
     * @param $rid 栏目id
     */
    public function hasChildClass($id) {
        $count = $this->where('parentid', $id)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断指定栏目下是否有文章
     * @param $rid 栏目id
     */
    public function hasArticle($cid) {
        $count = DB::table('class_article')->where('cid', $cid)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}
