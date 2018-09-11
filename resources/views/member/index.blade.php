@extends('layouts.include_withoutaui')
@section('content')
    <div class="page-container">
        <form>
            <div class="text-c">
                <a class="btn btn-success radius r btn-refresh"
                   style="line-height:1.6em;margin-top:3px"
                   href="javascript:location.replace(location.href);" title="刷新"><i
                            class="Hui-iconfont">&#xe68f;</i></a>
            </div>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                {{--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --}}
                <a class="btn btn-primary radius"
                   onclick="layer_show('添加用户', '{{ URL::asset("member/edit")}}', 800, 500)">
                <i class="Hui-iconfont">&#xe600;</i> 添加用户</a>
                </span>
            <span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span></div>
        {{--<div class="mt-20">--}}
        <table class="table table-border table-bordered table-bg table-sort">
            <thead>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="60">id</th>
                <th width="60">登录名</th>
                <th width="300">昵称</th>
                <th width="60">小程序用户</th>
                <th width="60">会员组</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $index=>$data)
                <tr class="text-c">
                    {{--{{json_encode($data)}}--}}
                    {{--<td><input type="checkbox" value="" name=""></td>--}}
                    <td>{{$data->userid}}</td>
                    <td>{{$data->username}}</td>
                    <td>{{$data->passport}}</td>
                    <td>@if(array_get($data,'wx_openId'))
                            <span class="label label-success radius">是</span>
                        @else
                            <span class="label label-default radius">否</span>
                        @endif
                    </td>
                    <td>@if(array_get($data,'groupid')==1)
                            <span class="label label-success radius">管理员</span>
                        @elseif(array_get($data,'groupid')==2)
                            <span class="label label-danger radius">禁止访问</span>
                        @elseif(array_get($data,'groupid')==3)
                            <span class="label label-default radius">游客</span>
                        @elseif(array_get($data,'groupid')==4)
                            <span class="label label-default radius">待审核会员</span>
                        @elseif(array_get($data,'groupid')==5)
                            <span class="label label-secondary radius">个人会员</span>
                        @elseif(array_get($data,'groupid')==6)
                            <span class="label label-primary radius">企业会员</span>
                        @else
                            <span class="label label-default radius">未知</span>
                        @endif
                    </td>
                    <td>
                        @if(array_get($data,'groupid')==6&&array_get($data,'wx_openId'))
                            <a style="text-decoration:none"
                               onclick="layer_show('用户详情', '{{ URL::asset("member/detail?userid=").$data->userid}}', 800, 500)"
                               href="javascript:;" title="名片详情">名片详情</a>
                        @endif
                            <a style="text-decoration:none"
                               onclick="layer_show('编辑名片', '{{ URL::asset("member/edit?userid=").$data->userid}}', 800, 500)"
                               href="javascript:;" title="编辑名片">编辑名片</a>
                        {{--@if($data->status==2)--}}
                        {{--<a style="text-decoration:none"--}}
                        {{--onClick="shenhe('{{json_encode($data)}}','{{json_encode($histories[$index])}}')"--}}
                        {{--href="javascript:;" title="审核">审核</a>--}}
                        {{--@else--}}
                        {{--<a style="text-decoration:none"--}}
                        {{--onClick="check('{{json_encode($data)}}','{{json_encode($histories[$index])}}')"--}}
                        {{--href="javascript:;" title="查看">查看</a>--}}
                        {{--@endif--}}

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{--</div>--}}
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
        $('.table-sort').dataTable({
            "aaSorting": [[1, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "pading": false,
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable": false, "aTargets": [1, 2, 3, 5]}// 不参与排序的列
            ]
        });


        //审核
        function shenhe(data_str, history_str) {
            console.log(data_str, history_str)
            var data = $.parseJSON(data_str);
            var history = $.parseJSON(history_str);
            var interText = doT.template($("#modal-content").text());
            var content = interText({data: data, history: history});
            showModal({
                title: 'title',
                content: content,
                buttons: ['通过', '驳回'],
                success: ['submit({id:' + data.id + ',result:true})', 'submit({id:' + data.id + ',result:false})'],
                fail: 'console.log(22222)'
            })
        }

        //查看
        function check(data_str, history_str) {
            console.log(data_str, history_str);
            var data = $.parseJSON(data_str);
            var history = $.parseJSON(history_str);
            var interText = doT.template($("#modal-content").text());
            var content = interText({data: data, history: history});
            showModal({
                title: 'title',
                content: content,
                buttons: [],
                success: [],
                fail: 'console.log()'
            })
        }

        function submit(param) {
            console.log(param)
            $.ajax({
                url: "{{url()->full()}}",
                type: 'POST',
                data: param,
                success: function (ret) {
                    console.log("ret is:", ret);
                    if (ret.result) {
                        $.Huimodalalert('提交成功！', 2000)
                        $("#modal-demo").modal("hide");
                        setTimeout(function () {
                            location.reload()
                        }, '2000')

                    } else {
                        $.Huimodalalert('提交失败！', 2000)
                    }
                }
            })
        }

        function Hui_alert(message, time) {
            console.log(132124156);
            $.Huimodalalert(message, time)
        }
    </script>
    <script type="text/javascript">
        /*
            参数解释：
            title	标题
            url		请求的url
            id		需要操作的数据id
            w		弹出层宽度（缺省调默认值）
            h		弹出层高度（缺省调默认值）
        */
        /*管理员-增加*/
        function admin_add(title, url, w, h) {
            layer_show(title, url, w, h);
        }

        /*管理员-删除*/
        function admin_del(obj, id) {
            layer.confirm('确认要删除吗？', function (index) {
                $.ajax({
                    type: 'POST',
                    url: '',
                    dataType: 'json',
                    success: function (data) {
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!', {icon: 1, time: 1000});
                    },
                    error: function (data) {
                        console.log(data.msg);
                    },
                });
            });
        }

        /*管理员-编辑*/
        function admin_edit(title, url, id, w, h) {
            layer_show(title, url, w, h);
        }

        /*管理员-停用*/
        function admin_stop(obj, id) {
            layer.confirm('确认要停用吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理……

                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                $(obj).remove();
                layer.msg('已停用!', {icon: 5, time: 1000});
            });
        }

        /*管理员-启用*/
        function admin_start(obj, id) {
            layer.confirm('确认要启用吗？', function (index) {
                //此处请求后台程序，下方是成功后的前台处理……


                $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                $(obj).remove();
                layer.msg('已启用!', {icon: 6, time: 1000});
            });
        }
    </script>
@endsection
