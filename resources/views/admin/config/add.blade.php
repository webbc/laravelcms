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
    @include("admin.common.top")
    @include("admin.common.nav")
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
                            <h3 class="box-title">添加管理员</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputVarname" class="col-sm-2 control-label">配置项</label>

                                    <div class="col-sm-4">
                                        <input type="text" name="varname" class="form-control" id="inputVarname"
                                               placeholder="配置项" aria-describedby="username">
                                    </div>
                                    <span class="span-danger">必填，不能超过20个字符</span>
                                </div>
                                <div class="form-group">
                                    <label for="inputInfo" class="col-sm-2 control-label">配置说明</label>

                                    <div class="col-sm-4">
                                        <input type="text" name="info" class="form-control" id="inputInfo"
                                               placeholder="配置说明" aria-describedby="username">
                                    </div>
                                    <span class="span-danger">必填，不能超过100个字符</span>
                                </div>
                                <div class="form-group">
                                    <label for="inputValue" class="col-sm-2 control-label">配置值</label>

                                    <div class="col-sm-4">
                                        <input type="text" name="value" class="form-control" id="inputValue"
                                               placeholder="配置值">
                                    </div>
                                    <span class="span-danger">必填，不能超过100个字符</span>
                                </div>
                                <div class="form-group">
                                    <label for="inputUsername" class="col-sm-2 control-label">类型</label>

                                    <div class="col-sm-2">
                                        <select class="form-control" name="type">
                                            <option value="string">string</option>
                                            <option value="int">int</option>
                                            <option value="boolean">boolean</option>
                                            <option value="img">img</option>
                                        </select>
                                    </div>
                                    <span class="span-danger">必选</span>
                                </div>
                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" onclick="javascript:quit();">取消</button>
                                <button type="submit" class="btn btn-info pull-right">添加</button>
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
    @include("admin.common.bottom")
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
<script>
    function quit() {
        var flag = confirm("确定放弃编辑吗？");
        if (flag == 1)
            location.href = '/admin/config/extend';
    }
</script>
</body>
</html>
