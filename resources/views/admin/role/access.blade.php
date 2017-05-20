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
    <!-- ztree style -->
    <link rel="stylesheet" href="/plugins/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">

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
            <ul id="treeDemo" class="ztree"></ul>
            <div style="height: 20px;"></div>
            <div>
                <button id="submit" class="btn btn-info pull">添加</button>
                <span id="msg" style="height:34px;line-height: 34px;color:#CC0000;margin-left: 15px;"></span>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('admin.common.bottom')

</div>
<!-- ./wrapper -->


<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- ztree -->
<script type="text/javascript" src="/plugins/ztree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/plugins/ztree/js/jquery.ztree.excheck.js"></script>


<!-- Bootstrap 3.3.6 -->
<script src="/js/bootstrap/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/dist/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/dist/demo.js"></script>
<SCRIPT type="text/javascript">
    //配置
    var setting = {
        check: {
            enable: true,
        },
        data: {
            simpleData: {
                enable: true
            }
        }
    };

    //节点
    var zNodes = [
            @foreach($perms as $perm)
        {
            id: {{$perm->id}},
            pId: {{$perm->parentid}},
            name: '{{$perm->name}}',

            @if(isset($perm->open))
                open: {{$perm->open}},
            @endif

            @if(isset($perm->checked))
                checked: {{$perm->checked}},
            @endif

            @if(isset($perm->chkDisabled))
                chkDisabled: {{$perm->chkDisabled}},
            @endif



        },
        @endforeach
    ];

    $(document).ready(function () {
        var zTree = $.fn.zTree.init($("#treeDemo"), setting, zNodes);//初始化树

        //提交数据
        $("#submit").click(function () {
            var checkCount = zTree.getCheckedNodes(true);
            var permIds = new Array();
            for (var i = 0; i < checkCount.length; i++) {
                permIds.push(checkCount[i].id);
            }
            $.ajax({
                url: "/admin/role/accessAdd",
                data: {permIds: permIds, roleId:{{$roleId}}},
                method: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.status == 200) {
                        $("#msg").text(data.msg);
                        window.setTimeout(function () {
                            location.href = "/admin/role/index";
                        }, 1000);
                    }
                }
            });
        });
    });
</SCRIPT>
</body>
</html>
