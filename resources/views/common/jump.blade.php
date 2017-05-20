<div id="applyFor" style="text-align: center; width: 500px; margin: 100px auto;">{{$message}},
    @if($url == '')
        将在<span class="loginTime" style="color: red">{{$jumpTime}}</span>秒后返回
            @else
                将在<span class="loginTime" style="color: red">{{$jumpTime}}</span>秒后跳转至<a href="{{$url}}"
                                                                                         style="color: red">首页</a>页面
    @endif
</div>


<!-- jQuery 2.2.3 -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    $(function () {
        var url = "{{$url}}";
        var loginTime = parseInt($('.loginTime').text());
        var time = setInterval(function () {
            loginTime = loginTime - 1;
            $('.loginTime').text(loginTime);
            if (loginTime == 0) {
                clearInterval(time);
                if (url == '') {
                    history.back();
                } else {
                    window.location.href = url;
                }
            }
        }, 1000);
    })
</script>