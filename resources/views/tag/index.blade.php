@extends('layouts.include_withoutaui')
@section('content')
    <div class="page-container">
        <form>
            <div class="text-c">
                {{--<button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>--}}
                <span class="select-box inline">
		<select name="status" class="select">
			<option value="0">全部分类</option>
            <option value="1">已驳回</option>
			<option value="2">未审核</option>
			<option value="3">已通过</option>
		</select>

		</span>
                {{--日期范围：--}}
                {{--<input name='timefrom' type="text"--}}
                {{--onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin"--}}
                {{--class="input-text Wdate" style="width:120px;">--}}
                {{-----}}
                {{--<input name='timeto' type="text"--}}
                {{--onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax"--}}
                {{--class="input-text Wdate" style="width:120px;">--}}
                {{--<input type="text" name="" id="" placeholder=" 资讯名称" style="width:250px" class="input-text">--}}
                <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 筛选
                </button>
                <a class="btn btn-success radius r btn-refresh"
                   style="line-height:1.6em;margin-top:3px"
                   href="javascript:location.replace(location.href);" title="刷新"><i
                            class="Hui-iconfont">&#xe68f;</i></a>
            </div>

        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                {{--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --}}
                <a class="btn btn-primary radius" onclick="admin_add('添加标签','{{ URL::asset("tag_edit")}}','800','500')">
                <i class="Hui-iconfont">&#xe600;</i> 添加标签</a>
                </span>
            <span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span></div>
        {{--<div class="mt-20">--}}
        <table class="table table-border table-bordered table-bg table-sort">
            <thead>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="60">标签id</th>
                <th width="60">模块</th>
                <th width="80">标签名称</th>
                <th width="80">文字描述</th>
                <th width="120">排序</th>
                <th width="120">状态</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $index=>$data)
                <tr class="text-c">
                    {{--<td><input type="checkbox" value="" name=""></td>--}}
                    <td>{{$data->tagid}}</td>
                    <td>
                        @if($data->moduleid==5)
                            <span class="label label-primary radius">供应</span>
                        @elseif($data->moduleid==6)
                            <span class="label label-success radius">求购</span>
                        @elseif($data->moduleid==88)
                            <span class="label label-warning radius">纺机贸易</span>
                        @else
                            <span class="label label-default radius">未知</span>
                        @endif
                    </td>
                    <td>{{$data->tagname}}</td>
                    <td>{{$data->desc}}</td>
                    <td>{{$data->listorder}}</td>
                    <td> @if($data->status==3)
                            <span class="label label-success radius">生效</span>
                        @else
                            <span class="label label-default radius">失效</span>
                        @endif</td>
                    <td>
                        <a style="text-decoration:none"
                           onclick="admin_add('编辑标签','{{ URL::asset("tag_edit?tagid=").$data->tagid}}','800','500')"
                           href="javascript:;" title="编辑">编辑</a>
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
                {"orderable": false, "aTargets": [2, 3, 6]}// 不参与排序的列
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
