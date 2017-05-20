<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Data Tables</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
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

    <!-- header bar -->
    @include('admin.common.top')
            <!-- nav bar -->
    @include('admin.common.nav')


            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('admin.common.mbx')

                <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <a class="btn btn-info" href="{{url('/admin/admin/add')}}">添加管理员</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th>管理员名称</th>
                                    <th>真实姓名</th>
                                    <th>邮箱</th>
                                    <th>电话</th>
                                    <th>是否在线</th>
                                    <th>上次登录IP</th>
                                    <th>上次登录时间</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
    @include('admin.common.bottom')
            <!-- footer bar -->

</div>
<!-- ./wrapper -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">确认删除</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" value="" id="roleid"/>
                您真的要删除吗？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a href="#" class="btn btn-primary">删除</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/js/bootstrap/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/dist/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/dist/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
        var roleId = {{$rid}};
        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-footer a').attr('href', '/admin/admin/del/' + id);
        });
        $("#example1").DataTable({
            "serverSide": true,
            "processing": true,
            "sort": false,
            "searchable": true,
            "language": {
                "zeroRecords": "没有找到记录",
                "processing": "正在加载数据...",
                "lengthMenu": "每页显示 _MENU_ 条记录",
                "info": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
                "infoEmpty": "当前显示 0 到 0 条，共 0 条记录",
                "infoFiltered": "(从 _MAX_ 条记录中筛选)",
                "search": "搜索",
                "searchPlaceholder": "用户名",
                "paginate": {
                    "first": "第一页",
                    "previous": " 上一页 ",
                    "next": " 下一页 ",
                    "last": " 最后一页 "
                }
            },
            "ajax": {
                "url": "/admin/admin/getData",
                "data": {'rid':roleId}
            },
            "columns": [
                {"data": "id"},
                {"data": "username"},
                {"data": "truename"},
                {"data": "email"},
                {"data": "telphone"},
                {
                    "data": "islogin",
                    "render": function (data) {
                        if (data == 1) return "在线";
                        else return "离线";
                    }
                },
                {
                    "data": "lastloginip",
                    "render": function (data, type, row) {
                        if (data == null) return "暂未登录";
                        else return row.loginipstring;
                    }
                },
                {
                    "data": "lastlogintime",
                    "render": function (data, type, row) {
                        if (data == null) return "暂未登录";
                        else return row.logintimestring;
                    }
                },
                {
                    "data": "status",
                    "render": function (data) {
                        if (data == 1) return "可用";
                        else return "禁用";
                    }
                },
                {
                    "data": null,
                    "defaultContent": "",
                    "render": function (data) {

                        var currentAdminId = {{session('admin')->id}};//当前管理员id
                        if (currentAdminId != data.id) {
                            return "<a href='/admin/admin/sendmsg/" + data.id + "'>留言</a>&nbsp;&nbsp;|&nbsp;&nbsp;"
                                    + "<a href='/admin/admin/edit/" + data.id + "'>修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;"
                                    + "<a href='#myModal' data-toggle='modal' data-id='" + data.id + "'>删除</a>";
                        } else {
                            return "<a href='/admin/admin/edit/" + data.id + "'>修改</a>&nbsp;&nbsp;|&nbsp;&nbsp;"
                                    + "<a href='#myModal' data-toggle='modal' data-id='" + data.id + "'>删除</a>";
                        }
                    }
                }
            ],
        })
        ;
    });
</script>
</body>
</html>