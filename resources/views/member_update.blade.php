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
                    <th width="60">状态</th>
                    <th width="80">会员ID</th>
                    <th width="80">会员名</th>
                    <th width="120">昵称</th>
                    <th width="120">申请时间</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $index=>$data)
                    <tr class="text-c">
                        {{--<td><input type="checkbox" value="" name=""></td>--}}
                        <td>{{$data->id}}</td>
                        <td>
                            @if($data->status==2)
                                <span class="label label-primary radius">待审核</span>
                            @elseif($data->status==3)
                                <span class="label label-success radius">通过</span>
                            @elseif($data->status==1)
                                <span class="label label-fail radius">驳回</span>
                            @else
                                <span class="label label-default radius">未知</span>
                            @endif
                        </td>
                        <td>{{$data->userid}}</td>
                        <td>{{$data->username}}</td>
                        <td>{{isset($data->user)?$data->user->passport:""}}</td>
                        <td>{{getPRCdate($data->addtime)}}</td>
                        <td>
                            @if($data->status==2)
                                <a style="text-decoration:none"
                                   onClick="shenhe('{{json_encode($data)}}','{{json_encode($histories[$index])}}')"
                                   href="javascript:;" title="审核">审核</a>
                            @else
                                <a style="text-decoration:none"
                                   onClick="check('{{json_encode($data)}}','{{json_encode($histories[$index])}}')"
                                   href="javascript:;" title="查看">查看</a>
                            @endif

                        </td>
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
                {"orderable": false, "aTargets": [3, 4, 6]}// 不参与排序的列
            ]
        });


        //审核
        function shenhe(data_str, history_str) {
            console.log(data_str, "history", history_str)
            var data = $.parseJSON(data_str);
            var history = $.parseJSON(history_str);
            var interText = doT.template($("#modal-content").text());
            var content = interText({data: data, history: history});
            showModal({
                title: '更新用户信息',
                content: content,
                buttons: ['通过', '驳回'],
                success: ['submit({id:' + data.id + ',result:true})', 'submit({id:' + data.id + ',result:false})'],
                fail: 'console.log(22222)'
            })
        }

        //查看
        function check(data_str, history_str) {
            console.log(data_str,'history', history_str);
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

    </script>
    <script id="modal-content" type="text/x-dot-template">
        <table class="table table-border table-bordered">
            <thead>
            <tr>
                <td>信息</td>
                <td>修改内容</td>
                <td>历史内容</td>
            </tr>
            </thead>
            <tr>
                <td>姓名</td>
                <td>@{{=it.data.truename }}</td>
                <td>@{{=it.history.truename }}</td>
            </tr>
            <tr>
                <td>公司名称</td>
                <td>@{{=it.data.company }}</td>
                <td>@{{=it.history.company }}</td>
            </tr>
            <tr>
                <td>职位</td>
                <td>@{{=it.data.career }}</td>
                <td>@{{=it.history.career }}</td>
            </tr>
            <tr>
                <td>业务类别</td>
                <td>@{{=it.data.ywlb_ids }}</td>
                <td>@{{=it.history.ywlb_ids }}</td>
            </tr>
            <tr>
                <td>详细地址</td>
                <td>@{{=it.data.address }}</td>
                <td>@{{=it.history.address }}</td>
            </tr>
            <tr>
                <td>主营产品</td>
                <td>@{{=it.data.business }}</td>
                <td>@{{=it.history.business }}</td>
            </tr>
            <tr>
                <td>公司简介</td>
                <td>@{{=it.data.introduce }}</td>
                <td>@{{=it.history.introduce }}</td>
            </tr>
            <tr>
                <td>相关图片</td>
                <td>
                    @{{~it.data.thumbs :src:idx }}
                    <img height="150px" src="@{{=src }}">
                    @{{~}}
                </td>
                <td>
                    @{{~it.history.thumbs :src:idx }}
                    <img height="150px" src="@{{=src }}">
                    @{{~}}
                </td>
            </tr>
            <tr>
                <td>微信二维码</td>
                <td>
                    <img height="150px" src="@{{=it.data.wxqr }}"></td>
                <td><img height="150px" src="@{{=it.history.wxqr }}">@</td>
            </tr>
        </table>
    </script>
@endsection
