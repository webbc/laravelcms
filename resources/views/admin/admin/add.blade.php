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
                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputUsername" class="col-sm-2 control-label">用户名</label>

                                    <div class="col-sm-4">
                                        <input type="text" name="username" class="form-control" id="inputUsername"
                                               placeholder="用户名" aria-describedby="username">
                                    </div>
                                    <span class="span-danger">不能由数字开头，3-12位</span>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">邮箱</label>

                                    <div class="col-sm-4">
                                        <input type="email" name="email" class="form-control" id="inputEmail"
                                               placeholder="邮箱">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputTrueName" class="col-sm-2 control-label">真实姓名</label>

                                    <div class="col-sm-4">
                                        <input type="text" name="truename" class="form-control" id="inputTrueName"
                                               placeholder="真实姓名">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputFile" class="col-sm-2 control-label">上传头像</label>

                                    <div class="col-sm-4">
                                        <input type="file" name="photo" class="form-control" id="inputFile"
                                               placeholder="头像">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputTel" class="col-sm-2 control-label">电话</label>

                                    <div class="col-sm-4">
                                        <input type="text" name="telphone" class="form-control" id="inputTel"
                                               placeholder="电话">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">密码</label>

                                    <div class="col-sm-4">
                                        <input type="password" name="password" class="form-control" id="inputPassword"
                                               placeholder="密码">
                                    </div>
                                    <span class="span-danger">6-16位</span>
                                </div>
                                <div class="form-group">
                                    <label for="inputRePassword" class="col-sm-2 control-label">确认密码</label>

                                    <div class="col-sm-4">
                                        <input type="password" name="repassword" class="form-control"
                                               id="inputRePassword" placeholder="确认密码">
                                    </div>
                                    <span class="span-danger">6-16位</span>
                                </div>
                                <div class="form-group">
                                    <label for="inputUsername" class="col-sm-2 control-label">所属角色</label>

                                    <div class="col-sm-4">
                                        <select class="form-control" name="rid">
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否启用</label>

                                    <div class="col-sm-4">
                                        <select class="form-control" name="status">
                                            <option value="1">启用</option>
                                            <option value="0">禁止</option>
                                        </select>
                                    </div>
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
            location.href = '/admin/admin/index';
    }
</script>
</body>
</html>
