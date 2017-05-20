<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/1 0001
 * Time: 15:06
 */

namespace App\Http\Controllers\Admin;


use App\Article;
use App\Column;
use App\Libs\UploadUtils;
use App\OperateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ArticleController {

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
    public function index($cid = null) {
        if ($cid == null) {
            $cid = 0;
        }
        return view('admin.article.index', ['cid' => $cid]);
    }

    //获取文章
    public function getData(Request $request) {
        $pageInfo = $this->getPageInfo($request);//分页信息
        $cid = $request->cid;//栏目id

        $articleModel = new Article();
        if (!is_null($cid)) {
            $articles = $articleModel->getArticle($cid, [0, 1], $pageInfo);
        } else {
            $articles = $articleModel->getArticle(0, [0, 1], $pageInfo);
        }
        $count = $articleModel->getArticleCount($cid, [0, 1], $pageInfo);
        return json_encode(
            [
                'draw' => $pageInfo['draw'],
                'recordsTotal' => $count['total'],
                'recordsFiltered' => $count['search'],
                'data' => $articles->toArray()
            ]
        );
    }

    //回收站页面
    public function rubbish() {
        return view('admin.article.rubbish');
    }

    //获取回收站文章
    public function getRubbishData(Request $request) {
        $pageInfo = $this->getPageInfo($request);//分页信息
        $articleModel = new Article();
        $articles = $articleModel->getArticle(0, [2], $pageInfo);
        $count = $articleModel->getArticleCount(0, [2], $pageInfo);
        return json_encode(
            [
                'draw' => $pageInfo['draw'],
                'recordsTotal' => $count['total'],
                'recordsFiltered' => $count['search'],
                'data' => $articles->toArray()
            ]
        );
    }

    //添加界面
    public function add() {
        $classModel = new Column();
        $classs = $classModel->getClass();
        $articleModel = new Article();
        $tpls = $articleModel->getContentTpl();
        return view('admin.article.add', ['classs' => $classs, 'tpls' => $tpls]);
    }

    //添加操作
    public function addpost(Request $request) {
        $article = new Article();
        //自动验证
        if (($error = $article->validate($request->all())) !== true) {
            return error($error);
        }
        $article->aid = $request->session()->get('admin')->id;
        $article->title = $request->title;
        $article->titlecolor = $request->titlecolor;
        $article->createtime = strtotime($request->createtime);
        $article->updatetime = time();
        $article->author = $request->author;
        $article->description = $request->description;
        $article->source = $request->source;
        $article->sort = $request->sort;
        $article->keywords = $request->keywords;
        $article->url = $request->url;
        $article->contenttplid = $request->contenttplid;
        $classname = '';
        foreach ($request->cid as $cid) {
            $class = DB::table('class')->where('id', $cid)->select('name')->first();
            $classname .= $class->name . ',';
        }
        $article->classname = rtrim($classname, ',');
        //上传文件
        if ($request->hasFile('thumb')) {
            $file = $request->file('thumb');
            $path = UploadUtils::getUploadPath($file->guessExtension());
            Image::make($file)->resize(env('THUMB_WIDTH'), env('THUMB_HEIGHT'))->save($path);
            $article->thumb = $path;
        }
        if ($article->save()) {
            $article->addArticleToClass($request->cid, $article->id);//添加文章到指定栏目
            $article->addArticleContent($article->id, $request->input('content'));//添加文章内容
            OperateLog::writeLog($request, 1, '添加文章成功');
            return success('添加成功', '/admin/article/index');
        } else {
            OperateLog::writeLog($request, 1, '添加文章失败');
            return error('添加失败');
        }
    }

    //修改页面
    public function edit($id) {
        $article = Article::find($id);//获取当前文章
        $classModel = new Column();
        $classs = $classModel->getClass();
        $classs = $article->setDefaultSelected($id, $classs);//获取所属栏目
        $tpls = $article->getContentTpl();//获取所有模板
        $content = $article->readArticleContent($id);
        return view('admin.article.edit', ['classs' => $classs, 'tpls' => $tpls, 'article' => $article, 'content' => $content]);
    }

    //修改操作
    public function editpost(Request $request, $id) {
        $article = Article::find($id);
        //自动验证
        if (($error = $article->validate($request->all())) !== true) {
            return error($error);
        }
        $article->aid = $request->session()->get('admin')->id;
        $article->title = $request->title;
        $article->titlecolor = $request->titlecolor;
        $article->createtime = strtotime($request->createtime);
        $article->updatetime = time();
        $article->author = $request->author;
        $article->description = $request->description;
        $article->source = $request->source;
        $article->sort = $request->sort;
        $article->keywords = $request->keywords;
        $article->url = $request->url;
        $article->contenttplid = $request->contenttplid;
        //上传文件
        if ($request->hasFile('thumb')) {
            $file = $request->file('thumb');
            $path = UploadUtils::getUploadPath($file->guessExtension());
            Image::make($file)->resize(env('THUMB_WIDTH'), env('THUMB_HEIGHT'))->save($path);
            $article->thumb = $path;
        }
        $classname = '';
        foreach ($request->cid as $cid) {
            $class = DB::table('class')->where('id', $cid)->select('name')->first();
            $classname .= $class->name . ',';
        }
        $article->classname = rtrim($classname, ',');
        if ($article->save()) {
            $article->delClassById($id);
            $article->addArticleToClass($request->cid, $id);//添加文章到指定栏目
            $article->updateArticleContent($id, $request->input('content'));//修改文章内容
            OperateLog::writeLog($request, 1, '修改文章成功');
            return success('修改成功', '/admin/article/index');
        } else {
            OperateLog::writeLog($request, 1, '修改文章失败');
            return error('修改失败');
        }
    }

    /**
     * 回收操作
     * @param $id 文章id
     */
    public function recycle(Request $request, $id) {
        $articleModel = new Article();
        $articleModel->recycle($id);
        OperateLog::writeLog($request, 1, '删除文章成功');
        return success('删除成功', '/admin/article/index', 3);
    }

    /**发布
     * @param $id 文章id
     */
    public function publish(Request $request, $id) {
        $articleModel = new Article();
        $articleModel->publish($id);
        OperateLog::writeLog($request, 1, '发布文章成功');
        return success('发布成功', '/admin/article/index', 3);
    }

    /**取消发布
     * @param $id 文章id
     */
    public function cancel(Request $request, $id) {
        $articleModel = new Article();
        $articleModel->cancel($id);
        OperateLog::writeLog($request, 1, '撤销发布文章成功');
        return success('撤销成功', '/admin/article/index', 3);
    }

    /**还原文档
     * @param $id 文章id
     */
    public function back(Request $request, $id) {
        $articleModel = new Article();
        $articleModel->back($id);
        OperateLog::writeLog($request, 1, '还原文章成功');
        return success('还原成功', '/admin/article/rubbish', 3);
    }

    /**永久删除文档
     * @param $id 文章id
     */
    public function del(Request $request, $id) {
        $articleModel = new Article();
        $articleModel->del($id);
        OperateLog::writeLog($request, 1, '永久删除文章成功');
        return success('永久删除成功', '/admin/article/rubbish', 3);
    }

}