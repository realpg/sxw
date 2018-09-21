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
                 <a class="btn btn-primary radius"
                    onclick="admin_add('添加广告','{{ URL::asset("ads_edit?pid=".$adplace->pid)}}','800','500')">
                <i class="Hui-iconfont">&#xe600;</i> 添加广告</a>
                </span>
            <span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span></div>
        {{--<div class="mt-20">--}}
        <table class="table table-border table-bordered table-bg table-sort">
            <thead>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="60">id</th>
                <th width="80">描述</th>
                <th width="60">广告位</th>
                <th width="150">价格</th>
                <th width="60">展示类别</th>
                <th width="60">信息类别</th>
                <th width="120">有效期</th>
                <th width="60">点击次数</th>
                <th width="60">启用状态</th>
                <th width="60">销售状态</th>
                <th width="30">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $index=>$data)
                <tr class="text-c">
                    {{--<td><input type="checkbox" value="" name=""></td>--}}
                    <td>{{$data->itemid}}</td>
                    <td>{{$data->desc}}</td>
                    <td>{{$adplace->name}}</td>
                    <td><ul id="Huifold1" class="Huifold">
                            <li class="item">
                                <h4>点击查看<b>+</b></h4>
                                <div class="info"> {{$data->amount0}}积分/{{$data->druation0/86400}}天 <br/> {{$data->amount1}}积分/{{$data->druation1/86400}}天 <br/> {{$data->amount2}}积分/{{$data->druation2/86400}}天 </div>
                            </li>
                        </ul>
                        </td>
                    <td>
                        @if($data->type==0)
                            <span class="label label-primary radius">图片</span>
                        @elseif($data->type==1)
                            <span class="label label-success radius">名片</span>
                        @elseif($data->type==2)
                            <span class="label label-warning radius">信息</span>
                        @else
                            <span class="label label-default radius">未知</span>
                        @endif
                    </td>
                    <td>
                        @if($data->linktype==1)
                            <span class="label label-primary radius">名片</span>
                        @elseif($data->linktype==2)
                            <span class="label label-success radius">信息</span>
                        @elseif($data->linktype==3)
                            <span class="label label-warning radius">外部链接</span>
                        @elseif($data->linktype==4)
                            <span class="label label-danger radius">客服</span>
                        @else
                            <span class="label label-default radius">未知</span>
                        @endif
                    </td>
                    <td @if($data->totime<time())class="c-red"@endif>
                        {{getPRCdate($data->fromtime,"Y-m-d")}} - {{getPRCdate($data->totime,"Y-m-d")}}</td>
                    <td @if(!$data->stat)class="c-red"@endif>
                        {{$data->hits}}</td>
                    <td>
                        @if($data->status==3)
                            <span class="label label-success radius">展示中</span>
                        @else
                            <span class="label label-default radius">未展示</span>
                        @endif
                    </td>
                    <td>
                        @if($data->onsell)
                            <span class="label label-success radius">销售中</span>
                        @else
                            <span class="label label-default radius">未销售</span>
                        @endif
                    </td>
                    <td>
                        <a style="text-decoration:none"
                           onclick="admin_add('编辑广告','{{ URL::asset("ads_edit?pid=").$data->xcx_pid.'&itemid='.$data->itemid}}','800','500')"
                           href="javascript:;" title="编辑">编辑</a>
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
        $.Huifold = function (obj, obj_c, speed, obj_type, Event) {
            if (obj_type == 2) {
                $(obj + ":first").find("b").html("-");
                $(obj_c + ":first").show()
            }
            $(obj).bind(Event, function () {
                if ($(this).next().is(":visible")) {
                    if (obj_type == 2) {
                        return false
                    }
                    else {
                        $(this).next().slideUp(speed).end().removeClass("selected");
                        $(this).find("b").html("+")
                    }
                }
                else {
                    if (obj_type == 3) {
                        $(this).next().slideDown(speed).end().addClass("selected");
                        $(this).find("b").html("-")
                    } else {
                        $(obj_c).slideUp(speed);
                        $(obj).removeClass("selected");
                        $(obj).find("b").html("+");
                        $(this).next().slideDown(speed).end().addClass("selected");
                        $(this).find("b").html("-")
                    }
                }
            })
        }

        $(function () {
            $.Huifold("#Huifold1 .item h4", "#Huifold1 .item .info", "fast", 1, "click");
            /*5个参数顺序不可打乱，分别是：相应区,隐藏显示的内容,速度,类型,事件*/
        });

        $('.table-sort').dataTable({
            "aaSorting": [[1, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "pading": false,
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable": false, "aTargets": [1,2,4,5,10]}// 不参与排序的列
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
