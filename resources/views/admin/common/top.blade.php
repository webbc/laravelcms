<header class="main-header">
    <!-- Logo -->
    <a href="{{url('/')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">CMS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Laravel</b>CMS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">@if(count($msg) != 0){{count($msg)}}@endif </span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(count($msg) != 0)
                            <li class="header">您有{{count($msg)}}条新信息</li>
                        @endif

                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                @foreach($msg as $v)
                                <!-- start message -->
                                <li>
                                    <a href="{{url('/admin/admin/allmsg')}}">
                                        <div class="pull-left">
                                            <img src="/{{$v->fromPhoto}}" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            {{$v->fromUsername}}
                                            <small><i class="fa fa-clock-o"></i> {{date('Y/m/d',$v->createtime)}}</small>
                                        </h4>
                                        <p>{{str_limit($v->msg,16)}}</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="{{url('/admin/admin/allmsg')}}">查看所有消息</a></li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/{{$admin->photo}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{$admin->username}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/{{$admin->photo}}" class="img-circle" alt="User Image">

                            <p>
                                真实姓名：{{$admin->truename}}
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <a href="{{url('/admin/admin/loginlog')}}">登录日志</a>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <a href="{{url('/admin/admin/operatelog')}}">操作日志</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{url('/admin/admin/edit',['id'=>$admin->id])}}"
                                   class="btn btn-default btn-flat">个人信息</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{url('/admin/login/loginout',['id'=>$admin->id])}}"
                                   class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>