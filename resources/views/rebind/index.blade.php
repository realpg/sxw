@extends('layouts.include_withoutaui')
@section('content')
    <div class="page-container">
        <div class="row cl">
            <div class="col-xs-5 col-sm-5 center-align">
                <div class="text-c">
                    <input type="number" step="1" min="1" name="user1" placeholder="原用户id" style="width:100%"
                           class="input-text userid">
                    <div class="user-info" style="width: 100%;height: 300px;margin-top: 20px">

                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-1 center-align text-c" style="height: 300px">
                <strong>
                    <i class="Hui-iconfont c-green">&#xe67d;</i></strong>
            </div>
            <div class="col-xs-5 col-sm-5 center-align">
                <div class="text-c">
                    <input type="number" step="1" min="1" name="user2" placeholder="新用户id" style="width:100%"
                           class="input-text userid">
                    <div class="user-info" style="width: 100%;height: 300px;margin-top: 20px">
                    </div>
                </div>
            </div>
        </div>
        <button id="submit" class="hidden btn btn-primary radius" onclick="check()">交换</button>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('hui/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/laypage/1.2/laypage.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/laypage/1.2/laypage.js')}}"></script>
    <script type="text/javascript">
        var user1 = null;
        var user2 = null;
        $(".userid").on('change', function () {
            var inputname = $(this).attr('name');
            var userid = $(this).val();

            var $userInfo = $(this).siblings(".user-info");
            $.ajax({
                url: "{{ URL::asset('getUserByUserid')}}",
                data: {
                    userid: userid
                },
                success: function (ret) {
                    console.log(ret);
                    if (ret.result) {
                        var userinfo = ret.ret;
                        var interText = doT.template($("#userInfo-content").text());
                        $userInfo.html(interText(userinfo));
                        if (inputname == 'user1') {
                            user1 = userinfo;
                        } else if (inputname == 'user2') {
                            user2 = userinfo;
                        }
                        if (user1 != null && user2 != null) {
//                            显示提交按钮
                            $("#submit").removeClass('hidden');
                        }
                        else {
//                            显示提交按钮
                            $("#submit").addClass('hidden');
                        }
                    }
                }
            })
        })

        function check() {
            showModal({
                title:'注意',
                content:'您正在将userid为【'+user2.userid+'】的用户小程序登录资格改绑到userid为【'+user1.userid+'】的用户。改绑后用户小程序端将使用【'+user2.userid+'】绑定的微信号登陆【'+user1.userid+'】的帐号，【'+user2.userid+'】内的帐号信息将消失。<br/><strong>您确定执行操作吗？</strong>',
                buttons:['确定'],
                success:['submit()']
            })
        }

        function submit() {
            console.log(user1,user2)
            $.ajax({
                url: "",
                type: "post",
                data: {
                    _token:"{{csrf_token()}}",
                    userid_1: user1.userid,
                    userid_2: user2.userid
                },
                success:function (ret) {
                    console.log(ret);
                    $.Huimodalalert(ret.message, 2000);
                    if (ret.result) {
                        setTimeout(
                        "location.replace(location.href)",3000)
                    }
                }
            })
        }
    </script>
    <script id="userInfo-content" type="text/x-dot-template">
        <table class="table table-border table-bordered">
            <tr>
                <td>ID</td>
                <td>@{{=it.userid }}</td>
            </tr>
            <tr>
                <td>昵称</td>
                <td>@{{=it.passport }}</td>
            </tr>
            <tr>
                <td>会员名</td>
                <td>@{{=it.username }}</td>
            </tr>
            <tr>
                <td>微信openid</td>
                <td>@{{=it.wx_openId }}</td>
            </tr>
        </table>
    </script>
@endsection
