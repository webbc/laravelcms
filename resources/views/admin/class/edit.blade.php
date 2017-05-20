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

    @include('admin.common.top')
    @include('admin.common.nav')
            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('admin.common.mbx')

                <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">修改栏目</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">父级栏目</label>

                                    <div class="col-sm-4">
                                        <select class="form-control" name="parentid">
                                            <option value="0">==作为顶级栏目==</option>
                                            @foreach($classs as $v)
                                                <option value="{{$v->id}}"
                                                        @if($class->parentid == $v->id)
                                                        selected="selected"
                                                        @endif
                                                >{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">栏目名称</label>

                                    <div class="col-sm-4">
                                        <input name="name" value="{{$class->name}}" type="text" class="form-control"
                                               id="inputName"
                                               placeholder="栏目名称">
                                    </div>
                                    <span class="span-danger">20个字符以内</span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板</label>

                                    <div class="col-sm-4">
                                        <select class="form-control" name="covertplid">
                                            <option value="-1">请选择模板</option>
                                            @foreach($tpls as $tpl)
                                                <option value="{{$tpl->id}}"
                                                        @if($class->covertplid == $tpl->id)
                                                        selected="selected"
                                                        @endif
                                                >{{$tpl->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">缩略图</label>
                                    <img src="/{{$class->thumb}}" alt="该栏目还没有设置缩略图"/>
                                </div>
                                <div class="form-group">
                                    <label for="inputFile" class="col-sm-2 control-label">栏目缩略图</label>

                                    <div class="col-sm-4">
                                        <input type="file" name="thumb" class="form-control" id="inputFile"
                                               placeholder="栏目缩略图">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription" class="col-sm-2 control-label">栏目描述</label>

                                    <div class="col-sm-4">
                                        <textarea class="form-control" id="inputDescription" rows="3"
                                                  placeholder="栏目描述"
                                                  name="description">{{$class->description}}</textarea>
                                    </div>
                                    <span class="span-danger">255个字符以内</span>
                                </div>
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">外部链接</label>

                                    <div class="col-sm-4">
                                        <input name="url" value="{{$class->url}}" type="text" class="form-control"
                                               id="inputName"
                                               placeholder="外部链接">
                                    </div>
                                    <span class="span-danger">如果该栏目为外部链接，请填入链接，如果不是外部链接，请不要填写</span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否在导航显示</label>

                                    <div class="col-sm-2">
                                        <select class="form-control" name="isnav">
                                            @if($class->isnav == 1)
                                                <option value="1" selected="selected">显示</option>
                                                <option value="0">隐藏</option>
                                            @else
                                                <option value="1">显示</option>
                                                <option value="0" selected="selected">隐藏</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否启用</label>

                                    <div class="col-sm-2">
                                        <select class="form-control" name="status">
                                            @if($class->status == 1)
                                                <option value="1" selected="selected">启用</option>
                                                <option value="0">禁止</option>
                                            @else
                                                <option value="1">启用</option>
                                                <option value="0" selected="selected">禁止</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">排序</label>

                                    <div class="col-sm-2">
                                        <input name="sort" value="{{$class->sort}}" type="text" class="form-control"
                                               id="inputName"
                                               placeholder="排序">
                                    </div>
                                    <span id="spanTel" class="span-danger">*数字越低，排序越前</span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">栏目内容</label>

                                    <div class="col-sm-8">
                                        <script id="editor" name='content' type="text/plain"
                                                style="width:100%;min-height:300px;">{!! $content!!}</script>
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" onclick="javascript:quit();">取消</button>
                                <button type="submit" class="btn btn-info pull-right">修改</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('admin.common.bottom')
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/js/bootstrap/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/dist/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/dist/demo.js"></script>

<!-- ueditor -->
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
    var ue = UE.getEditor('editor', {
        autoHeight: false
    });
    function quit() {
        var flag = confirm("确定放弃编辑吗？");
        if (flag == 1)
            location.href = '/admin/class/index';
    }
</script>
</body>
</html>
