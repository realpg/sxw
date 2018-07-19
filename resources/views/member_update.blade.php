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
            </div>
        </form>
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                {{--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --}}
                {{--<a class="btn btn-primary radius" data-title="添加资讯" data-href="article-add.html" onclick="Hui_admin_tab(this)" href="javascript:;">--}}
                {{--<i class="Hui-iconfont">&#xe600;</i> 添加资讯</a></span> --}}
                <span class="r">共有数据：<strong>{{$datas->count()}}</strong> 条</span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
                <thead>
                <tr class="text-c">
                    {{--<th width="25"><input type="checkbox" name="" value=""></th>--}}
                    <th width="60">ID</th>
                    <th width="80">会员ID</th>
                    <th width="80">会员名</th>
                    <th width="120">昵称</th>
                    <th width="120">申请时间</th>
                    {{--<th width="120">操作</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr class="text-c">
                        {{--<td><input type="checkbox" value="" name=""></td>--}}
                        <td>{{$data->id}}</td>
                        <td>@if($data->moduleid==5)
                                <span class="label label-primary radius">供应</span>
                            @elseif($data->moduleid==6)
                                <span class="label label-success radius">求购</span>
                            @else
                                <span class="label label-default radius">未知</span>
                            @endif
                        </td>
                        <td>{{$data->itemid}}</td>
                        <td>{{$data->userid}}</td>
                        <td>{{$data->username}}</td>
                        <td>{{$data->passport}}</td>
                        <td>{{$data->time}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
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
                {"orderable": false, "aTargets": [4, 5]}// 不参与排序的列
            ]
        });
    </script>
@endsection
