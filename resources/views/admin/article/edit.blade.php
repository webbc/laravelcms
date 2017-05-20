<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | General Form Elements</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--自定义css-->
    <link rel="stylesheet" href="/css/custom/common.css">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/plugins/datetimepicker/css/bootstrap-datetimepicker.css">
    <!-- select2 -->
    <link rel="stylesheet" href="/plugins/select2/select2.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/dist/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/css/dist/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <form id="form" method="post" enctype="multipart/form-data">
                    <!-- right column -->
                    <div class="col-md-8">
                        <!-- Horizontal Form -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">修改文章</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="form-horizontal">
                                {{csrf_field()}}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputTitle" class="col-sm-2 control-label">标题</label>

                                        <div class="col-sm-6">
                                            <input name="title" type="text" class="form-control" id="inputTitle"
                                                   placeholder="标题"
                                                   aria-describedby="username" value="{{$article->title}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSource" class="col-sm-2 control-label">来源</label>

                                        <div class="col-sm-6">
                                            <input name="source" value="{{$article->source}}" type="text"
                                                   class="form-control" id="inputSource"
                                                   placeholder="来源">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputClass" class="col-sm-2 control-label">所属栏目</label>

                                        <div class="col-sm-6">
                                            <select class="form-control select2" multiple="multiple"
                                                    data-placeholder="发布到多个栏目" name="cid[]">
                                                @foreach($classs as $class)
                                                    <option value="{{$class->id}}" {{$class->selected}}>{{$class->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAuthor" class="col-sm-2 control-label">作者</label>

                                        <div class="col-sm-6">
                                            <input name="author" value="{{$article->author}}" type="text"
                                                   class="form-control" id="inputAuthor"
                                                   placeholder="作者">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputKeywords" class="col-sm-2 control-label">关键字</label>

                                        <div class="col-sm-6">
                                            <input name="keywords" value="{{$article->keywords}}" type="text"
                                                   class="form-control" id="inputKeywords"
                                                   placeholder="以分号分隔">
                                        </div>
                                        <span id="spanPassword"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDescription" class="col-sm-2 control-label">文章描述</label>

                                        <div class="col-sm-6">
                                        <textarea class="form-control" id="inputDescription" rows="3"
                                                  placeholder="文章描述"
                                                  name="description">{{$article->description}}</textarea>
                                        </div>
                                        <span id="spanRePassword"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputURL" class="col-sm-2 control-label">文章内容</label>

                                        <div class="col-sm-6">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <script id="editor" name='content' type="text/plain"
                                                    style="width:100%;min-height:300px;">{!! $content !!}


                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div style="text-align: center;">
                                            <input type="checkbox" name="choosecontent" checked="checked">
                                            是否截取内容<input type="text" style="width:30px;height:20px;" name="length"
                                                         value="200" class="text">字符至内容摘要 &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" name="choosepic" checked="checked">是否获取内容第<input
                                                    type="text"
                                                    style="width:30px;height:20px;"
                                                    name="picnum"
                                                    value="1"
                                                    class="text">张图片作为标题图片
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="col-md-4">
                        <!-- Horizontal Form -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">修改文章</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">缩略图</label>
                                        <img src="/{{$article->thumb}}"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputFile" class="col-sm-3 control-label">上传图片</label>

                                        <div class="col-sm-8">
                                            <input type="file" name="thumb" class="form-control" id="inputFile"
                                                   placeholder="缩略图"
                                                   aria-describedby="username">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="datetimepicker" class="col-sm-3 control-label">发布时间</label>

                                        <div class="col-sm-8">
                                            <input type="text" value="{{date('Y/m/d H:i',$article->createtime)}}"
                                                   name="createtime"
                                                   class="form-control" id="datetimepicker"
                                                   placeholder="发布时间">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputTitlecolor" class="col-sm-3 control-label">标题颜色</label>

                                        <div class="col-sm-8">
                                            <input type="text" value="{{$article->titlecolor}}" name="titlecolor"
                                                   class="form-control my-colorpicker1 colorpicker-element"
                                                   id="inputTitlecolor" placeholder="标题颜色">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputUrl" class="col-sm-3 control-label">跳转链接</label>

                                        <div class="col-sm-8">
                                            <input type="text" name="url" value="{{$article->url}}" class="form-control"
                                                   id="inputUrl"
                                                   placeholder="跳转链接">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">内容模板</label>

                                        <div class="col-sm-8">
                                            <select class="form-control" name="contenttplid">
                                                @foreach($tpls as $tpl)
                                                    <option value="{{$tpl->id}}"
                                                            @if($article->contenttplid == $tpl->id)
                                                            selected="selected"
                                                            @endif
                                                    >{{$tpl->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputWeight" class="col-sm-3 control-label">排序</label>

                                        <div class="col-sm-4">
                                            <input type="text" name="sort" value="{{$article->sort}}"
                                                   class="form-control"
                                                   id="inputWeight" placeholder="排序">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!--/.col (right) -->
                </form>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div style="width: 100%;height: 50px;"></div>
</div>
<!-- ./wrapper -->

<div class="bottom">
    <button type="button" class="btn btn-default" onclick="javascript:quit();">取消</button>
    <button type="button" class="btn btn-info" id="add">修改</button>
</div>

<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/js/bootstrap/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="/plugins/select2/select2.full.min.js"></script>
<!-- FastClick -->
<script src="/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/dist/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/dist/demo.js"></script>
<!-- bootstrap datepicker -->
<script src="/plugins/datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/plugins/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<!-- bootstrap color picker -->
<script src="/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- ueditor -->
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

<!-- page script -->
<script>
    $(".select2").select2();
    var ue = UE.getEditor('editor', {
        autoHeight: false
    });
    //Date picker
    $('#datetimepicker').datetimepicker({
        autoclose: true,
        language: 'zh-CN',
        format: 'yyyy/mm/dd hh:ii',
    });
    $(".my-colorpicker1").colorpicker();
    $(function () {
        $('#add').click(function () {
            $('#form').submit();
        });
    });
    function quit() {
        var flag = confirm("确定放弃编辑吗？");
        if (flag == 1)
            location.href = '/admin/article/index';
    }
</script>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2 0002
 * Time: 19:05
 */