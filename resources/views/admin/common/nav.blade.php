<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/{{$admin->photo}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{$admin->username}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">菜单面板</li>
            @foreach($menu as $m)
            <li class="treeview {{$m->active}}">
                <a href="{{$m->router}}">
                    <i class="fa fa-dashboard"></i> <span>{{$m->name}}</span>
                    @if($m->childMenu != null)
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    @endif
                </a>
                @if($m->childMenu != null)
                <ul class="treeview-menu">
                    @foreach($m->childMenu as $subM)
                        <li class="{{$subM->active}}"><a href="{{$subM->router}}"><i class="fa fa-circle-o"></i>{{$subM->name}}</a></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>