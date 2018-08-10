@extends('layouts.include_withoutaui')
@section('content')
    <div class="page-container">
        <form>
            <div class="text-c">
                {{--<button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>--}}
                {{--<span class="select-box inline">--}}
                {{--<select name="status" class="select">--}}
                {{--<option value="0">全部分类</option>--}}
                {{--<option value="1">已驳回</option>--}}
                {{--<option value="2">未审核</option>--}}
                {{--<option value="3">已通过</option>--}}
                {{--</select>--}}

                {{--</span>--}}
                {{--日期范围：--}}
                {{--<input name='timefrom' type="text"--}}
                {{--onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin"--}}
                {{--class="input-text Wdate" style="width:120px;">--}}
                {{-----}}
                {{--<input name='timeto' type="text"--}}
                {{--onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax"--}}
                {{--class="input-text Wdate" style="width:120px;">--}}
                {{--<input type="text" name="" id="" placeholder=" 资讯名称" style="width:250px" class="input-text">--}}
                {{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 筛选--}}
                {{--</button>--}}
                <a class="btn btn-success radius r btn-refresh"
                   style="line-height:1.6em;margin-top:3px"
                   href="javascript:location.replace(location.href);" title="刷新"><i
                            class="Hui-iconfont">&#xe68f;</i></a>
            </div>

        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">当前页：{{$datas->currentPage()}}，共{{$datas->lastPage()}}页</span>
            <span class="r">
            <a href="{{$datas->previousPageUrl()}}">上一页</a>
                <a href="{{$datas->nextPageUrl()}}">下一页</a>
            </span>
            <span class="r">共有数据：<strong>{{$datas->perPage()}}/{{$datas->total()}}</strong> </span>

        </div>
        {{--<div class="mt-20">--}}
        <table class="table table-border table-bordered table-bg table-sort">
            <thead>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="60">id</th>
                <th width="60">时间</th>
                <th width="300">URL</th>
                <th width="60">请求方式</th>
                <th width="150">ip</th>
                <th width="300">参数</th>
                <th width="120">返回值</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $index=>$data)
                <tr class="text-c">
                    {{--<td><input type="checkbox" value="" name=""></td>--}}
                    <td>{{$data->id}}</td>
                    <td>{{getPRCdate($data->time)}}</td>
                    <td>{{$data->url}}</td>
                    <td>{{$data->method}}</td>
                    <td>{{$data->ip}}</td>
                    <td>{{$data->param}}</td>
                    <td>@if($data->response){
                        {{$data->response?"失败":"成功"}}</td>
                    }
                    @endif
                    <td>
                        <a style="text-decoration:none"
                           onclick="view({{json_encode($data->response)}})"
                           href="javascript:;" title="查看">查看</a>
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
                {"orderable": false, "aTargets": [7]}// 不参与排序的列
            ]
        });

function view(content) {
    showModal({
        title: '响应内容',
        content: content,
        buttons: [],
        success: [],
        fail: 'console.log(22222)'
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
