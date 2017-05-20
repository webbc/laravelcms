<html style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Timeline</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
<body class="skin-blue sidebar-mini" style="height: auto;">
<div class="wrapper" style="height: auto;">

    @include('admin.common.top')
    @include('admin.common.nav')
            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1036px;">
        <!-- Content Header (Page header) -->
        @include('admin.common.mbx')
                <!-- Main content -->
        <section class="content">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <ul class="timeline">
                        @foreach($msgs as $k=>$msg)
                                <!-- timeline time label -->
                        <li class="time-label">

                            @if($looper[$k] % 2 == 0)
                                <span class="bg-red">{{$k}}</span>
                            @else
                                <span class="bg-green">{{$k}}</span>
                            @endif

                            <a class="btn btn-info btn-l" style="margin-left:20px;"
                               href="{{url('/admin/admin/readAll')}}">把所有消息标记为已读</a>
                        </li>

                        <!-- /.timeline-label -->
                        @foreach($msg as $v)
                                <!-- timeline item -->
                        <li>
                            <i class="fa fa-envelope bg-blue"></i>

                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i>{{date('H:i:s',$v->createtime)}}</span>

                                <h3 class="timeline-header"><a
                                            href="{{url('/admin/admin/sendmsg',['id'=>$v->fromid])}}">{{$v->fromUsername}}</a>
                                    发送给你的消息
                                    <a class="btn btn-default btn-xs">
                                        @if($v->status == 1)已读
                                        @else 未读
                                        @endif
                                    </a></h3>

                                <div class="timeline-body">
                                    {{$v->msg}}
                                </div>
                                <div class="timeline-footer">
                                    @if($v->status == 0)
                                        <a class="btn btn-info btn-xs"
                                           href="{{url('/admin/admin/read',['id'=>$v->id])}}">标记为已读</a>
                                    @endif
                                    <a class="btn btn-primary btn-xs"
                                       href="{{url('/admin/admin/sendmsg',['id'=>$v->fromid])}}">回复</a>
                                    <a href="{{url('/admin/admin/delmsg',['id'=>$v->id])}}"
                                       class="btn btn-danger btn-xs">删除</a>
                                </div>
                            </div>
                        </li>
                        <!-- END timeline item -->
                        @endforeach
                        @endforeach

                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>
                </div>
                <!-- /.col -->
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


</body>
</html>