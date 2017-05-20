<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{$mbx[0]->name}}
        <small>{{$mbx[1]->name}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard/index')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="{{$mbx[0]->router}}">{{$mbx[0]->name}}</a></li>
        <li class="active">{{$mbx[1]->name}}</li>
    </ol>
</section>