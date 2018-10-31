@extends('layouts.include_withoutaui')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/lib/Hui-iconfont/1.0.9/iconfont.css')}}"/>
    <div class="page-container">
        <div class="page-container">
            <div class="text-c">
                <form id="file-form">
                    <span class="btn-upload form-group">
                          <input class="input-text upload-url radius" type="text" name="file-1" id="uploadfile-1"
                                 readonly><a
                                class="btn btn-primary radius"><i class="Hui-iconfont">&#xe642;</i> 读取文件</a>
                          <input type="file" multiple name="file" class="input-file" onchange="uploadfile()">
                    </span>
                    {{csrf_field()}}
                </form>

            </div>

            <div class="cl pd-5 bg-1 bk-gray mt-20 show_if_has_data hidden">
                <span class="l">
                    共读取到 <strong id="data_length"></strong> 条数据,此处仅显示前 <strong id="data_count"></strong> 条
                </span>


                <span class="r">
                {{--<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> --}}


                    <a class="btn btn-primary radius"
                       onclick="start()">
                    <i class="Hui-iconfont">&#xe6e6;</i> 开始导入</a>
                </span>

                <span class="select-box r" style="width: 300px">
                    <span class="l"><label for="mid">信息类型</label></span>
                    <span class="r"><select id="mid" class="select" size="1" name="mid" style="width: 150px">
                        <option value="5">供应信息</option>
                        <option value="5">求购信息</option>
                        {{--<option value="88">纺机贸易</option>--}}
                    </select></span>
                </span>


            </div>


            <table class="table table-border table-bordered table-bg table-sort show_if_has_data hidden">
                <thead>
                <tr class="text-c">
                    <td width="30">编号</td>
                    <td width="30">信息发布人id</td>
                    <td width="30">分类id</td>
                    <td width="120">地址</td>
                    <td width="120">描述</td>
                    <td width="60">标签id</td>
                    <td width="120">公司图片</td>
                    <td width="90">发布时间</td>
                </tr>
                </thead>
                <tbody id="table-area"></tbody>
            </table>
        </div>
        @endsection

        @section('script')
            <script type="text/javascript" src="{{ URL::asset('hui/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
            <script type="text/javascript"
                    src="{{ URL::asset('hui/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
            <script type="text/javascript" src="{{ URL::asset('hui/lib/laypage/1.2/laypage.js')}}"></script>

            <script id="table-content" type="text/x-dot-template">

                @{{~it :row:index }}
                <tr class="text-c">
                    <td>@{{=index+1 }}</td>
                    <td>@{{=row.userid }}</td>
                    <td>@{{=row.catid }}</td>
                    <td>@{{=row.address }}</td>
                    <td>@{{=row.desc }}</td>
                    <td>@{{=row.tag_ids }}</td>
                    <td>@{{=row.thumb }}</td>
                    <td>@{{=row.addtime }}</td>
                </tr>
                @{{~}}

            </script>
            <script>
                var data_length = 0;
                var page = 0;
                var file_path='';
                var _token="{{csrf_token()}}";

                function uploadfile() {
                    $("#file-form").ajaxSubmit({
                        type: 'POST', // 提交方式 get/post
                        url: '{{URL::asset('UploadExcel')}}', // 需要提交的 url
                        success: function (ret) { // data 保存提交后返回的数据，一般为 json 数据
                            // 此处可对 data 作相关处理
                            console.log(ret, ret.ret, ret.ret.data)
                            $(".show_if_has_data").removeClass('hidden')
                            alert('上传成功！');
                            data_length = ret.ret.data_length;
                            file_path = ret.ret.file_path;
                            $("#data_length").html(ret.ret.data_length);
                            $("#data_count").html(ret.ret.data.length);
                            makeTable(ret.ret.data);
                        }
                    })
                }

                function start() {
                    var mid=$("#mid").val();
                    console.log(mid,file_path,page,_token)
                    $.ajax({
                        type:"POST",
                        url:"{{URL::asset('import/start')}}",
                        data:{
                            mid:mid,
                            file_path:file_path,
                            page:page,
                            _token:_token
                        },
                        success:function (ret) {
                            console.log("导入返回",ret);
                            $.Huimodalalert('导入成功！正在获取导入结果',2000)
                            setTimeout(function () {
                                window.location.href="{{URL::asset('import/result?result_file_path=')}}"+ret.ret;
                            },2500);
                        }
                    })
                }

                function makeTable(data) {
                    console.log(data);
                    var interText = doT.template($("#table-content").text());
                    $("#table-area").html(interText(data));

                    $('.table-sort').dataTable({
                        "aaSorting": [[1, "desc"]],//默认第几个排序
                        "bStateSave": true,//状态保存
                        "pading": false,
                        "aoColumnDefs": [
                            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                            {"orderable": false, "aTargets": [1, 2, 3, 4, 5, 6, 7]}// 不参与排序的列
                        ]
                    });
                }
            </script>
@endsection