<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Article extends Model {
    public $timestamps = false;
    public $table = 'article';

    private $rules = [
        'title' => 'required|max:100',
        'createtime' => 'required',
        'sort' => 'required|integer',
        'url' => 'nullable|url',
        'contenttplid' => 'required|integer',
        'cid' => 'required|array'
    ];

    private $messages = [
        'required' => ':attribute不能为空',
        'integer' => ':attribute必须是数字',
        'max' => ':attribute超过了最大范围',
        'url' => ':attribute必须是一个URL',
        'array' => ':attribute必须是一个数组'
    ];

    private $attribute = [
        'title' => '标题',
        'createtime' => '发布时间',
        'sort' => '排序',
        'url' => '外部链接',
        'contenttplid' => '模板',
        'cid' => '所属栏目'
    ];

    /**
     * 获取管理员的个数
     * @param int $rid
     * @param null $pageInfo
     */
    public function getArticleCount($cid = 0, $status = null, $pageInfo = null) {
        if (empty($status)) return null;
        $count = [];
        if ($cid == 0) {//不存在指定栏目，查询所有
            $count['total'] = $this->whereIn('status', $status)->count();
            if ($pageInfo['search'] == '') {
                $count['search'] = $count['total'];
            } else {
                $count['search'] = $this->whereIn('status', $status)->where('title', 'like', "%{$pageInfo['search']}%")->count();
            }
        } else {//查询指定角色下的管理员
            $count['total'] = DB::table('class_article')
                ->leftJoin('article', 'class_article.aid', '=', 'article.id')
                ->where('article.status', '!=', 3)
                ->where('class_article.cid', '=', $cid)
                ->count();
            if ($pageInfo['search'] == '') {
                $count['search'] = $count['total'];
            } else {
                $count['search'] = DB::table('class_article')
                    ->leftJoin('article', 'class_article.aid', '=', 'article.id')
                    ->where('article.status', '!=', 3)
                    ->where('class_article.cid', '=', $cid)
                    ->where('article.title', 'like', "%{$pageInfo['search']}%")
                    ->count();
            }
        }
        return $count;
    }

    /**
     * 获取指定状态下的文章
     * @param array $status 文章状态
     * @return null|array 文章数组
     */
    public function getArticle($cid = 0, $status = [], $pageInfo = null) {
        if (empty($status)) return null;
        if ($cid == 0) {//不存在指定栏目，查询所有
            if ($pageInfo == null) {//没有分页
                $articles = $this
                    ->leftJoin('admin', 'article.aid', '=', 'admin.id')
                    ->select('article.*', 'admin.username')
                    ->whereIn('article.status', $status)
                    ->orderBy('article.sort', 'asc')
                    ->orderBy('article.createtime', 'desc')
                    ->get();
            } else {
                if ($pageInfo['search'] == '') {
                    $articles = $this
                        ->leftJoin('admin', 'article.aid', '=', 'admin.id')
                        ->select('article.*', 'admin.username')
                        ->whereIn('article.status', $status)
                        ->orderBy('article.sort', 'asc')
                        ->orderBy('article.createtime', 'desc')
                        ->offset($pageInfo['start'])
                        ->limit($pageInfo['length'])
                        ->get();
                } else {
                    $articles = $this
                        ->leftJoin('admin', 'article.aid', '=', 'admin.id')
                        ->where('title', 'like', "%{$pageInfo['search']}%")
                        ->whereIn('article.status', $status)
                        ->orderBy('article.sort', 'asc')
                        ->orderBy('article.createtime', 'desc')
                        ->offset($pageInfo['start'])
                        ->limit($pageInfo['length'])
                        ->get();
                }
            }
        } else {//查询指定栏目下的文章
            if ($pageInfo == null) {//没有分页
                $articles = DB::table('class_article')
                    ->leftJoin('article', 'class_article.aid', '=', 'article.id')
                    ->leftJoin('admin', 'article.aid', '=', 'admin.id')
                    ->select('article.*', 'admin.username')
                    ->where('article.status', '!=', 3)
                    ->where('class_article.cid', '=', $cid)
                    ->whereIn('article.status', $status)
                    ->orderBy('article.sort', 'asc')
                    ->orderBy('article.createtime', 'desc')
                    ->get();
            } else {
                if ($pageInfo['search'] == '') {
                    $articles = DB::table('class_article')
                        ->leftJoin('article', 'class_article.aid', '=', 'article.id')
                        ->leftJoin('admin', 'article.aid', '=', 'admin.id')
                        ->select('article.*', 'admin.username')
                        ->where('article.status', '!=', 3)
                        ->where('class_article.cid', '=', $cid)
                        ->orderBy('article.sort', 'asc')
                        ->orderBy('article.createtime', 'desc')
                        ->offset($pageInfo['start'])
                        ->limit($pageInfo['length'])
                        ->get();
                } else {
                    $articles = DB::table('class_article')
                        ->leftJoin('article', 'class_article.aid', '=', 'article.id')
                        ->leftJoin('admin', 'article.aid', '=', 'admin.id')
                        ->select('article.*', 'admin.username')
                        ->where('article.status', '!=', 3)
                        ->where('class_article.cid', '=', $cid)
                        ->where('title', 'like', "%{$pageInfo['search']}%")
                        ->orderBy('article.sort', 'asc')
                        ->orderBy('article.createtime', 'desc')
                        ->offset($pageInfo['start'])
                        ->limit($pageInfo['length'])
                        ->get();
                }
            }
        }
        //转换数据格式
        foreach ($articles as $article) {
            $article->createtimestr = date('Y/m/d H:i:s', $article->createtime);
        }
        return $articles;
    }

    /**
     * 获取所有内容模板
     * @return array 模板数据
     */
    public function getContentTpl() {
        return DB::table('content_tpl')->get();
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
     * 添加文章到栏目
     * @param array $cids 栏目
     * @param $aid 文章
     * @return bool 标识
     */
    public function addArticleToClass($cids = [], $aid) {
        if (empty($cids)) return false;
        foreach ($cids as $cid) {
            DB::table('class_article')->insert(['cid' => $cid, 'aid' => $aid]);
        }
        return true;
    }


    /**
     * 删除指定文章的所属栏目
     * @param $id 文章id
     */
    public function delClassById($id) {
        return DB::table('class_article')->where('aid', $id)->delete();
    }

    /**
     * 判断文章内容是否存在
     * @param $id 文章id
     * @return bool 是否存在
     */
    public function isContentExist($id) {
        if (DB::table('article_detail')->where('aid', $id)->first()) {
            return true;
        } else {
            false;
        }
    }

    /**
     * 添加文章内容
     * @param $id 文章id
     * @param $content 内容
     */
    public function addArticleContent($id, $content) {
        DB::table('article_detail')->insert(['aid' => $id, 'content' => $content]);
    }

    /**
     * 读取文章内容
     * @param $id 文章id
     * @return string 文章内容
     */
    public function readArticleContent($id) {
        if ($this->isContentExist($id)) {
            $content = DB::table('article_detail')->select('content')->where('aid', $id)->first()->content;
            return $content;
        }
        return '';
    }

    /**
     * 修改文章内容
     * @param $id 文章id
     * @param $content 文章内容
     */
    public function updateArticleContent($id, $content) {
        if ($this->isContentExist($id)) {
            DB::table('article_detail')->where('aid', $id)->update(['content' => $content]);
        } else {
            $this->addClassContent($id, $content);
        }
    }

    /**
     * 获取文章的所属栏目
     * @param $id 文章ID
     * @return array 栏目数组
     */
    private function getClass($id) {
        return DB::table('class_article')->select('cid')->where('aid', $id)->get();
    }


    /**
     * 默认选中文章所属栏目
     * @param $id 文章ID
     * @param $classs 栏目数组
     * @return array 栏目数组
     */
    public function setDefaultSelected($id, $classs) {
        $cids = $this->getClass($id);
        foreach ($cids as $cid) {
            foreach ($classs as $class) {
                if ($cid->cid == $class->id) {
                    $class->selected = "selected = 'selected'";
                }
            }
        }
        return $classs;
    }

    /**
     * 发布文章
     * @param $id 文章id字符
     */
    public function publish($id) {
        $ids = explode(',', $id);
        $this->whereIn('id', $ids)->update(['status' => 1]);
    }

    /**
     * 发布文章
     * @param $id 文章id字符
     */
    public function cancel($id) {
        $ids = explode(',', $id);
        $this->whereIn('id', $ids)->update(['status' => 0]);
    }

    /**
     * 回收文章
     * @param $id 文章id字符
     */
    public function recycle($id) {
        $ids = explode(',', $id);
        $this->whereIn('id', $ids)->update(['status' => 2]);
    }

    /**
     * 还原文章
     * @param $id 文章id字符
     */
    public function back($id) {
        $ids = explode(',', $id);
        $this->whereIn('id', $ids)->update(['status' => 1]);
    }

    /**
     * 永久删除文章
     * @param $id 文章id字符
     */
    public function del($id) {
        $ids = explode(',', $id);
        $this->whereIn('id', $ids)->update(['status' => 4]);
    }
}
