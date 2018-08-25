@extends('layouts.include_withoutaui')
@section('content')
    <div class="page-container">
        <form>
            <div class="text-c">
                {{--<button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>--}}
                <span class="select-box inline">
		{{--<select name="status" class="select">--}}
                    {{--<option value="0">全部分类</option>--}}
                    {{--<option value="1">已驳回</option>--}}
                    {{--<option value="2">未审核</option>--}}
                    {{--<option value="3">已通过</option>--}}
                    {{--</select>--}}

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
                {{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 筛选--}}
                {{--</button>--}}
                <a class="btn btn-success radius r btn-refresh"
                   style="line-height:1.6em;margin-top:3px"
                   href="javascript:location.replace(location.href);" title="刷新"><i
                            class="Hui-iconfont">&#xe68f;</i></a>
            </div>

        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                </span>
            <span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span></div>
        {{--<div class="mt-20">--}}
        <table class="table table-border table-bordered table-bg table-sort">
            <thead>
            <tr class="text-c">
                {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                <th width="60">记录id</th>
                <th width="80">用户userid</th>
                <th width="80">vip等级</th>
                <th width="120">购买时间</th>
                <th width="120">生效时间</th>
                <th width="120">失效时间</th>
                <th width="60">状态</th>
                <th width="60">所付积分</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datas as $index=>$data)
                <tr class="text-c">
                    {{--<td><input type="checkbox" value="" name=""></td>--}}
                    <td>{{$data->id}}</td>
                    <td>{{$data->userid}}</td>
                    <td>{{$data->vip}}</td>
                    <td>{{getPRCdate($data->addtime)}}</td>
                    <td>{{getPRCdate($data->fromtime)}}</td>
                    <td>{{getPRCdate($data->totime)}}</td>
                    <td>=
                        @if($data->status==0)
                            <span class="label label-secondary radius">待生效</span>
                        @elseif($data->status==2)
                            <span class="label label-default radius">过期</span>
                        @elseif($data->status==3)
                            <span class="label label-success radius">生效</span>
                        @endif
                    </td>
                    <td>{{$data->amount}}</td>
                    <td>
                        {{--<a style="text-decoration:none" onclick="note('{{$data->id}}','{{$data->note}}')"--}}
                        {{--href="javascript:;" title="备注">编辑备注</a>--}}
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
                {"orderable": false, "aTargets": [6,8]}// 不参与排序的列
            ]
        });

        //查看
        function note(id, note) {
            console.log(id, note);

            var interText = doT.template($("#modal-content").text());
            var content = interText({id: id, note: note});
            showModal({
                title: '备注',
                content: content,
                buttons: ['提交'],
                success: ['submit()'],
                fail: 'console.log()'
            })
        }

        function submit() {
            var param = $('#note').serializeArray()
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

    <script id="modal-content" type="text/x-dot-template">
        <form id="note">
            <input class="hidden" value="@{{=it.id}}" name="id">
            <textarea style="width: 100%" name="note">
                @{{=it.note}}
            </textarea>
        </form>
    </script>
@endsection
