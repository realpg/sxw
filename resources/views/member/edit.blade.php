<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    {{--<link rel="Bookmark" href="{{ URL::asset('hui/favicon.ico'}}" >--}}
    {{--<link rel="Shortcut Icon" href="{{ URL::asset('hui//favicon.ico'}}" />--}}
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/html5shiv.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/respond.min.js')}}"></script>
    <![endif]-->
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui/css/H-ui.min.css')}}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui/css/H-ui.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('hui/bootstrapSwitch.css')}}">
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui.admin/css/H-ui.admin.css')}}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/lib/Hui-iconfont/1.0.8/iconfont.css')}}"/>
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui.admin/skin/default/skin.css')}}"--}}
          {{--id="skin"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui.admin/css/style.css')}}"/>--}}
    <!--[if IE 6]>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/DD_belatedPNG_0.0.8a-min.js')}}"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ URL::asset('hui/lib/webuploader/0.1.5/webuploader.css')}}" rel="stylesheet" type="text/css"/>
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/app.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/aui.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/default/style.css') }}"/>--}}
    <title>纱线网小程序后台</title>
    <style>
        img {
            height: 220px;
        }
    </style>
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-article-add" method="post">
        {{csrf_field()}}
        <div class="row cl ">
            <label class="form-label col-xs-4 col-sm-2">用户id：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text hidden" value="{{array_get($data,'userid')}}" placeholder=""
                       id="userid" name="userid" >
                {{array_get($data,'userid')}}
            </div>
        </div>

        <div class="row cl type type-0">
            <label class="form-label col-xs-4 col-sm-2">头像：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    @if(!array_get($data,'avatarUrl'))
                        <div id="fileList0" class="uploader-list">
                        </div>
                        <div id="filePicker0">选择图片</div>
                        <div id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">开始上传</div>
                    @else
                        <div id="fileList0" class="uploader-list">
                            <div id="" class="item">
                                <div class="pic-box" id="filePicker0"><img height="220" class=""
                                                                           src='{{array_get($data,'avatarUrl')}}'></div>
                                <div class="info"></div>
                            </div>
                            <input class="hidden" name="avatarUrl" value="{{array_get($data,'avatarUrl')}}"/>

                        </div>
                        <div id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">重新上传</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{array_get($data,'truename')}}" placeholder=""
                       id="truename" name="truename">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>会员级别：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="radio-box">
                    <input type="radio" id="groupid-5" name="groupid" value="5"
                           @if(array_get($data,'groupid')==5)checked
                            @endif>
                    <label for="groupid-5">个人会员</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="groupid-6" name="groupid" value="6"
                           @if(isset($data['user']))
                           @if(array_get($data['user'],'groupid')==6)checked
                            @endif
                            @endif>
                    <label for="groupid-6">企业会员</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="groupid-1" name="groupid" value="1"
                           @if(isset($data['user']))
                           @if(array_get($data['user'],'groupid')==1)checked
                            @endif
                            @endif disabled>
                    <label for="groupid-1"><del> 管理员 </del></label>
                </div>
                {{--<input type="text" class="input-text" value="{{array_get($data,'ywlb_ids')}}" placeholder=""--}}
                {{--id="ywlb_ids" name="ywlb_ids">--}}
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>手机：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{array_get($data,'mobile')}}" placeholder=""
                       id="mobile" name="mobile">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司照片：</label>
            {{--<div class="formControls col-xs-8 col-sm-9">--}}
            {{--<div class="uploader-list-container">--}}
            {{--<div class="queueList">--}}
            {{--<div id="dndArea" class="placeholder">--}}
            {{--<div id="filePicker-2"></div>--}}
            {{--<p>或将照片拖到这里，单次最多可选9张</p>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="statusBar" style="display:none;">--}}
            {{--<div class="progress"><span class="text">0%</span> <span class="percentage"></span></div>--}}
            {{--<div class="info"></div>--}}
            {{--<div class="btns">--}}
            {{--<div id="filePicker2"></div>--}}
            {{--<div class="uploadBtn">开始上传</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container row">

                    <div id="uploader_arr" class="wu-example">
                        <!--用来存放文件信息-->
                        <div id="fileList_arr" class="uploader-list">
                            @if(array_get($data,'thumb'))
                                @foreach(explode(',',array_get($data,'thumb')) as $index=>$img)

                                    <div id="arr_{{$index}}" class="item" style="float:left">
                                        {{--<div id="arr_WU_FILE_0" class="item" style="float:left">--}}


                                        <div class="pic-box">
                                            <img height="220px" src="{{$img}}">
                                        </div>
                                        {{--<div class="info c-success f-18">timg (23).jpeg</div>--}}
                                        {{--</div>--}}
                                        <span class="cancel" onclick="delete_form_arr('arr_{{$index}}')">删除</span>
                                        <input class="hidden" name="thumb[]" value="{{$img}}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="btn_arr">
                            <div id="picker_arr">选择图片</div>
                            <div id="btn-star_arr" class="btn btn-default btn-uploadstar radius ml-10">开始上传</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{array_get($data,'company')}}" placeholder=""
                       id="company" name="company">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司职位：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{array_get($data,'career')}}" placeholder=""
                       id="career" name="career">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>业务类别：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @foreach($ywlbs as $idx=>$ywlb)
                    <div class="check-box">
                        {{--{{json_encode($ywlbs)}}--}}
                        <input type="checkbox" id="ywlb-{{$idx}}" value="{{$ywlb->id}}" name="ywlb_ids[]"
                               @if(in_array($ywlb->id,explode(',',array_get($data,'ywlb_ids'))))checked
                                @endif>
                        <label for="ywlb-{{$idx}}">{{$ywlb->name}}</label>
                    </div>
                @endforeach
                {{--<input type="text" class="input-text" value="{{array_get($data,'ywlb_ids')}}" placeholder=""--}}
                {{--id="ywlb_ids" name="ywlb_ids">--}}
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>详细地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{array_get($data,'address')}}" placeholder=""
                       id="address" name="address">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>主营产品：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea class="textarea radius " id="business"
                          name="business">{{array_get($data,'business')}}</textarea>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>公司简介：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea class="textarea radius " id="introduce"
                          name="introduce">{{array_get($data,'introduce')}}</textarea>
            </div>
        </div>

        <div class="row cl type type-0">
            <label class="form-label col-xs-4 col-sm-2">微信二维码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    @if(!array_get($data,'wxqr'))
                        <div id="fileList1" class="uploader-list">
                        </div>
                        <div id="filePicker1">选择图片</div>
                        <div id="btn-star1" class="btn btn-default btn-uploadstar radius ml-10">开始上传</div>
                    @else
                        <div id="fileList1" class="uploader-list">
                            <div id="" class="item">
                                <div class="pic-box" id="filePicker1"><img height="220"
                                                                           src='{{array_get($data,'wxqr')}}'></div>
                                <div class="info"></div>
                            </div>
                            <input class="hidden" name="wxqr" value="{{array_get($data,'wxqr')}}"/>
                        </div>
                        <div id="btn-star1" class="btn btn-default btn-uploadstar radius ml-10">重新上传</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <p class="c-danger">* 请尽量避免修改活跃用户的信息</p>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button onClick="save_submit();" class="btn btn-primary radius" type="button"><i
                            class="Hui-iconfont">&#xe632;</i> 保存并提交
                </button>
                {{--<button onClick="article_save();" class="btn btn-secondary radius" type="button"><i--}}
                {{--class="Hui-iconfont">&#xe632;</i> 保存草稿--}}
                {{--</button>--}}
                <button onClick="layer_close();" class="btn btn-default radius" type="button">
                    &nbsp;&nbsp;取消&nbsp;&nbsp;
                </button>
            </div>
        </div>
    </form>
</article>

<script type="text/javascript" src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/webuploader/0.1.5/webuploader.min.js')}}"></script>
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/ueditor/1.4.3/ueditor.config.js')}}"></script>--}}
<script type="text/javascript" src="{{ URL::asset('hui/lib/ueditor/1.4.3/ueditor.all.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/bootstrapSwitch.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('hui/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/static/h-ui.admin/js/H-ui.admin.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('hui/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/laypage/1.2/laypage.js')}}"></script>

<script>
    //    $('#create-switch').wrap('<div class="switch" />').parent().bootstrapSwitch();
    function delete_form_arr(dom_id) {
        var dom = $('#' + dom_id);
        dom.remove();
    }

    function save_submit() {
        var $form = $("form");
        var param = $form.serialize();
        console.log("提交表单", param)
        var toast_content = {
            company: "公司名称",
            career: "职位",
            address: "详细地址",
            introduce: "公司简介",
            business: "主营产品",
            mobile: "手机",
            truename: "姓名",
            ywlb_ids: "业务类别",
            thumb: "公司照片",
            avatarUrl: "头像",
            groupid:"会员级别"
        }
        var t = $form.serializeArray();
        $.each(t, function () {
            var name = this.name.replace(/\[\]/, '');
            if (toast_content[name])
                toast_content[name] = true;
            console.log(name, this)
        });
        for (var i in toast_content) {
            console.log(toast_content[i])
            if (toast_content[i] !== true) {
                var title = '请填写' + toast_content[i] + '！'
                alert(title)
                return;
            }
        }
        $.post({
            url: '',
            data: param,
            success: function (ret) {
                var index = parent.layer.getFrameIndex(window.name);
                parent.Hui_alert(ret.message, 2000);
//                parent.$('.btn-refresh').click();

                console.log(ret, ret.ret, typeof(ret));
                if (ret.result) {
                    parent.location.replace(parent.location.href)
                    layer_close();
                }
            },
            error: function (ret) {
                console.log(ret, typeof(ret));
            }
        });
    }

    function layer_close() {
        var index = parent.layer.getFrameIndex(window.name);

        parent.layer.close(index);
    }

    function UserDetail(url) {
        var userid = $('#userid').val();
        console.log(url + '?userid=' + userid);
        layer_show('用户详情', url + '?userid=' + userid, 800, 500)
    }

    $(function () {
        var $list = $("#fileList0"),
            $btn = $("#btn-star"),
            state = "pending",
            $list1 = $("#fileList1"),
            $btn1 = $("#btn-star1"),
            state1 = "pending",
            thumbnailWidth = 220,
            thumbnailHeight = 220,
            thumbnailWidth1 = 220,
            thumbnailHeight1 = 220;

        var uploader0 = WebUploader.create({
            auto: true,
            swf: "{{ URL::asset('hui/lib/webuploader/0.1.5/Uploader.swf')}}",

            // 文件接收服务端。
            server: "{{ URL::asset('upload')}}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {id: '#filePicker0'},
            formData: {
                uid: 123,
                _token: "{{csrf_token()}}"
            },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

        var uploader1 = WebUploader.create({
            auto: true,
            swf: "{{ URL::asset('hui/lib/webuploader/0.1.5/Uploader.swf')}}",

            // 文件接收服务端。
            server: "{{ URL::asset('upload')}}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {id: '#filePicker1'},
            formData: {
                uid: 123,
                _token: "{{csrf_token()}}"
            },
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        uploader0.on('fileQueued', function (file) {
            var $li = $(
                '<div id="u0_' + file.id + '" class="item">' +
                '<div class="pic-box"><img></div>' +
                '<div class="info">' + file.name + '</div>' +
                '<p class="state">等待上传...</p>' +
                '</div>'
                ),
                $img0 = $li.find('img');
            $list.html($li);

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader0.makeThumb(file, function (error, src) {
                if (error) {
                    $img0.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img0.attr('src', src);
            }, thumbnailWidth, thumbnailHeight);
        });
        uploader1.on('fileQueued', function (file) {

            var $li = $(
                '<div id="u1_' + file.id + '" class="item">' +
                '<div class="pic-box"><img></div>' +
                '<div class="info">' + file.name + '</div>' +
                '<p class="state">等待上传...</p>' +
                '</div>'
                ),
                $img1 = $li.find('img');
            $list1.html($li);
            console.log("添加文件", file, $li, $img1)

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader1.makeThumb(file, function (error, src) {
                if (error) {
                    $img1.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img1.attr('src', src);
            }, thumbnailWidth1, thumbnailHeight1);
        });
        // 文件上传过程中创建进度条实时显示。
        uploader0.on('uploadProgress', function (file, percentage) {
            var $li = $('#u0_' + file.id),
                $percent = $li.find('.progress-box .sr-only');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo($li).find('.sr-only');
            }
            $li.find(".state").text("上传中");
            $percent.css('width', percentage * 100 + '%');
        });
        // 文件上传过程中创建进度条实时显示。
        uploader1.on('uploadProgress', function (file, percentage) {
            var $li = $('#u1_' + file.id),
                $percent = $li.find('.progress-box .sr-only');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo($li).find('.sr-only');
            }
            $li.find(".state").text("上传中");
            $percent.css('width', percentage * 100 + '%');
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader0.on('uploadSuccess', function (file, ret) {
            console.log(file, ret);
            var img = ret.ret;
            $('#u0_' + file.id).addClass('upload-state-success').find(".state").text("已上传");
            var $li = $(
                '<div id="u0_' + file.id + '" class="item">' +
                '<div class="pic-box"><img height="220px" src=' + img + '></div>' +
                '<div class="info">' + file.name + '</div>' +
                '</div>' + '<input class="hidden" name="avatarUrl" value="' + img + '"/>'
                ),
                $img0 = $li.find('img');
            $list.html($li);
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader1.on('uploadSuccess', function (file, ret) {
            console.log(file, ret);
            var img = ret.ret;
            $('#u1_' + file.id).addClass('upload-state-success').find(".state").text("已上传");
            var $li = $(
                '<div id="u1_' + file.id + '" class="item">' +
                '<div class="pic-box"><img height="220px" src=' + img + '></div>' +
                '<div class="info">' + file.name + '</div>' +
                '</div>' + '<input class="hidden" name="wxqr" value="' + img + '"/>'
                ),
                $img1 = $li.find('img');
            $list1.html($li);
        });

        // 文件上传失败，显示上传出错。
        uploader0.on('uploadError', function (file) {
            $('#u0_' + file.id).addClass('upload-state-error').find(".state").text("上传出错");
        });
        // 文件上传失败，显示上传出错。
        uploader1.on('uploadError', function (file) {
            $('#u1_' + file.id).addClass('upload-state-error').find(".state").text("上传出错");
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader0.on('uploadComplete', function (file) {
            $('#u0_' + file.id).find('.progress-box').fadeOut();
        });
        uploader1.on('uploadComplete', function (file) {
            $('#u1_' + file.id).find('.progress-box').fadeOut();
        });
        uploader0.on('all', function (type) {
            if (type === 'startUpload') {
                state = 'uploading';
            } else if (type === 'stopUpload') {
                state = 'paused';
            } else if (type === 'uploadFinished') {
                state = 'done';
            }

            if (state === 'uploading') {
                $btn.text('暂停上传');
            } else {
                $btn.text('开始上传');
            }
        });
        uploader1.on('all', function (type) {
            if (type === 'startUpload') {
                state1 = 'uploading';
            } else if (type === 'stopUpload') {
                state1 = 'paused';
            } else if (type === 'uploadFinished') {
                state1 = 'done';
            }

            if (state1 === 'uploading') {
                $btn1.text('暂停上传');
            } else {
                $btn1.text('开始上传');
            }
        });

        $btn.on('click', function () {
            if (state === 'uploading') {
                uploader0.stop();
            } else {
                uploader0.upload();
            }
        });

        $btn1.on('click', function () {
            if (state1 === 'uploading') {
                uploader1.stop();
            } else {
                uploader1.upload();
            }
        });
//        createUploader_arr()
    });
    jQuery(function () {
        var $ = jQuery,
            $list = $('#fileList_arr'),
            $btn_arr = $('#btn-star_arr'),
            state_arr = 'pending',
            uploader_arr;
        uploader_arr = WebUploader.create({
            // 不压缩image
            auto: true,
            resize: false,

            // swf文件路径
            swf: "{{ URL::asset('hui/lib/webuploader/0.1.5/Uploader.swf')}}",

            // 文件接收服务端。
            server: "{{ URL::asset('upload')}}",
            formData: {
                uid: 123,
                _token: "{{csrf_token()}}"
            },
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },


            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#picker_arr'

        });

        // 当有文件添加进来的时候
        uploader_arr.on('fileQueued', function (file) {
            console.log("file", file);
//            $list.append('<div id="arr_' + file.id + '" class="item">' +
//                '<h4 class="info">' + file.name + '</h4>' +
//                '<p class="state">等待上传...</p>' +
//                '</div>');


            var $li = $(
                '<div id="arr_' + file.id + '" class="item"  style="float:left">' +
                '<div class="pic-box"><img height="220px"></div>' +
                '<div class="info">' + file.name + '</div>' +
                '<p class="state c-orange f-18">等待上传...</p>' +
                '</div>'
                ),
                $img_arr = $li.find('img');
            $list.append($li);

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader_arr.makeThumb(file, function (error, src) {
                if (error) {
                    $img_arr.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img_arr.attr('src', src);
            }, 220, 220);

        });

        // 文件上传过程中创建进度条实时显示。
        uploader_arr.on('uploadProgress', function (file, percentage) {

            var $li = $('#arr_' + file.id),
                $percent = $li.find('.progress .progress-bar');
            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo($li).find('.progress-bar');
            }
            $li.find('p.state').text('上传中');
            $percent.css('width', percentage * 100 + '%');

        });

        uploader_arr.on('uploadSuccess', function (file, ret) {
            console.log('已上传', file, ret);
            var $file = $('#arr_' + file.id);
            $file.find('p.state').text('已上传').addClass('upload-state-success');
            var img = ret.ret;
            var $li = $(
                '<div class="pic-box"><img height="220px" src=' + img + '></div>' +
                '<div class="info c-success f-18">' + file.name + '</div>' +
                '<span class="cancel del_form_arr" onclick="delete_form_arr(\'arr_' + file.id + '\')">删除</span>' +
                '<input class="hidden" name="thumb[]" value="' + img + '"/>'
                ),
                $img1 = $li.find('img');
            $file.html($li);
        });

        uploader_arr.on('uploadError', function (file) {
            $('#arr_' + file.id).find('p.state').text('上传出错').addClass('c-warning');
        });

        uploader_arr.on('uploadComplete', function (file) {
            $('#arr_' + file.id).find('.progress').fadeOut();
        });
        uploader_arr.on('all', function (type) {
            if (type === 'startUpload') {
                state_arr = 'uploading';
            } else if (type === 'stopUpload') {
                state_arr = 'paused';
            } else if (type === 'uploadFinished') {
                state_arr = 'done';
            }
            if (state_arr === 'uploading') {
                $btn_arr.text('暂停上传');
            } else {
                $btn_arr.text('开始上传');
            }

        });

        $btn_arr.on('click', function () {
            if (state_arr === 'uploading') {
                uploader_arr.stop();
            } else {
                uploader_arr.upload();
            }
        });
    });

    // 当domReady的时候开始初始化
    function createUploader_arr() {
//        linktypeChange($("#linktype").val());


        //<-<-<-<-<-<-以上为初始化单个上传
        //以下为批量上传->->->->->

        var $wrap = $('.uploader-list-container'),

            // 图片容器
            $queue = $('<ul class="filelist"></ul>')
                .appendTo($wrap.find('.queueList')),

            // 状态栏，包括进度和控制按钮
            $statusBar = $wrap.find('.statusBar'),

            // 文件总体选择信息。
            $info = $statusBar.find('.info'),

            // 上传按钮
            $upload_arr = $wrap.find('.uploadBtn'),

            // 没选择文件之前的内容。
            $placeHolder = $wrap.find('.placeholder'),

            $progress = $statusBar.find('.progress').hide(),

            // 添加的文件数量
            fileCount = 0,

            // 添加的文件总大小
            fileSize = 0,

            // 优化retina, 在retina下这个值是2
            ratio = window.devicePixelRatio || 1,


            // 可能有pedding, ready, uploading, confirm, done.
            state_arr = 'pedding',

            // 所有文件的进度信息，key为file id
            percentages = {},
            // 判断浏览器是否支持图片的base64
            isSupportBase64 = (function () {
                var data = new Image();
                var support = true;
                data.onload = data.onerror = function () {
                    if (this.width != 1 || this.height != 1) {
                        support = false;
                    }
                }
                data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                return support;
            })(),

            // 检测是否已经安装flash，检测flash的版本
            flashVersion = (function () {
                var version;

                try {
                    version = navigator.plugins['Shockwave Flash'];
                    version = version.description;
                } catch (ex) {
                    try {
                        version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                            .GetVariable('$version');
                    } catch (ex2) {
                        version = '0.0';
                    }
                }
                version = version.match(/\d+/g);
                return parseFloat(version[0] + '.' + version[1], 10);
            })(),

            supportTransition = (function () {
                var s = document.createElement('p').style,
                    r = 'transition' in s ||
                        'WebkitTransition' in s ||
                        'MozTransition' in s ||
                        'msTransition' in s ||
                        'OTransition' in s;
                s = null;
                return r;
            })(),

            // WebUploader实例
            uploader_arr;

        if (!WebUploader.Uploader.support('flash') && WebUploader.browser.ie) {

            // flash 安装了但是版本过低。
            if (flashVersion) {
                (function (container) {
                    window['expressinstallcallback'] = function (state_arr) {
                        switch (state_arr) {
                            case 'Download.Cancelled':
                                alert('您取消了更新！')
                                break;

                            case 'Download.Failed':
                                alert('安装失败')
                                break;

                            default:
                                alert('安装已成功，请刷新！');
                                break;
                        }
                        delete window['expressinstallcallback'];
                    };

                    var swf = 'expressInstall.swf';
                    // insert flash object
                    var html = '<object type="application/' +
                        'x-shockwave-flash" data="' + swf + '" ';

                    if (WebUploader.browser.ie) {
                        html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                    }

                    html += 'width="100%" height="100%" style="outline:0">' +
                        '<param name="movie" value="' + swf + '" />' +
                        '<param name="wmode" value="transparent" />' +
                        '<param name="allowscriptaccess" value="always" />' +
                        '</object>';

                    container.html(html);

                })($wrap);

                // 压根就没有安转。
            } else {
                $wrap.html('<a href="http://www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>');
            }

            return;
        } else if (!WebUploader.Uploader.support()) {
            alert('Web Uploader 不支持您的浏览器！');
            return;
        }

        // 实例化
        uploader_arr = WebUploader.create({
            pick: {
                id: '#filePicker-2',
                label: '点击选择图片'
            },
            formData: {
                uid: 123,
                _token: "{{csrf_token()}}"
            },
            dnd: '#dndArea',
            paste: '#uploader_arr',
            swf: "{{ URL::asset('hui/lib/webuploader/0.1.5/Uploader.swf')}}",

            // 文件接收服务端。
            server: "{{ URL::asset('upload')}}",
            chunked: false,
            chunkSize: 512 * 1024,
            // runtimeOrder: 'flash',

            // accept: {
            //     title: 'Images',
            //     extensions: 'gif,jpg,jpeg,bmp,png',
            //     mimeTypes: 'image/*'
            // },

            // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
            disableGlobalDnd: true,
            fileNumLimit: 9,
            fileSizeLimit: 200 * 1024 * 1024,    // 200 M
            fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M
        });

        // 拖拽时不接受 js, txt 文件。
        uploader_arr.on('dndAccept', function (items) {
            var denied = false,
                len = items.length,
                i = 0,
                // 修改js类型
                unAllowed = 'text/plain;application/javascript ';

            for (; i < len; i++) {
                // 如果在列表里面
                if (~unAllowed.indexOf(items[i].type)) {
                    denied = true;
                    break;
                }
            }

            return !denied;
        });

        uploader_arr.on('dialogOpen', function () {
            console.log('here');
        });

        // uploader.on('filesQueued', function() {
        //     uploader.sort(function( a, b ) {
        //         if ( a.name < b.name )
        //           return -1;
        //         if ( a.name > b.name )
        //           return 1;
        //         return 0;
        //     });
        // });

        // 添加“添加文件”的按钮，
        uploader_arr.addButton({
            id: '#filePicker2',
            label: '继续添加'
        });

        uploader_arr.on('ready', function () {
            window.uploader_arr = uploader_arr;
        });

        // 当有文件添加进来时执行，负责view的创建
        function addFile(file) {
            var $li = $('<li id="arr_' + file.id + '">' +
                '<p class="title">' + file.name + '</p>' +
                '<p class="imgWrap"></p>' +
                '<p class="progress"><span></span></p>' +
                '</li>'),

                $btns = $('<div class="file-panel">' +
                    '<span class="cancel">删除</span>' +
                    '<span class="rotateRight">向右旋转</span>' +
                    '<span class="rotateLeft">向左旋转</span></div>').appendTo($li),
                $prgress = $li.find('p.progress span'),
                $wrap = $li.find('p.imgWrap'),
                $info = $('<p class="error"></p>'),

                showError = function (code) {
                    switch (code) {
                        case 'exceed_size':
                            text = '文件大小超出';
                            break;

                        case 'interrupt':
                            text = '上传暂停';
                            break;

                        default:
                            text = '上传失败，请重试';
                            break;
                    }

                    $info.text(text).appendTo($li);
                };

            if (file.getStatus() === 'invalid') {
                showError(file.statusText);
            } else {
                // @todo lazyload
                $wrap.text('预览中');
                uploader_arr.makeThumb(file, function (error, src) {
                    var img;

                    if (error) {
                        $wrap.text('不能预览');
                        return;
                    }

                    if (isSupportBase64) {
                        img = $('<img id="arr_' + file.id + '" src="' + src + '">');
                        $wrap.empty().append(img);
                    } else {
                        $.ajax('lib/webuploader/0.1.5/server/preview.php', {
                            method: 'POST',
                            data: src,
                            dataType: 'json'
                        }).done(function (response) {
                            console.log("返回", response)
                            if (response.result) {
                                img = $('<img src="' + response.result + '">');
                                $wrap.empty().append(img);
                            } else {
                                $wrap.text("预览出错");
                            }
                        });
                    }
                }, thumbnailWidth, thumbnailHeight);

                percentages['arr_' + file.id] = [file.size, 0];
                file.rotation = 0;
            }

            file.on('statuschange', function (cur, prev) {
                if (prev === 'progress') {
                    $prgress.hide().width(0);
                } else if (prev === 'queued') {
                    $li.off('mouseenter mouseleave');
                    $btns.remove();
                }

                // 成功
                if (cur === 'error' || cur === 'invalid') {
                    console.log(file.statusText);
                    showError(file.statusText);
                    percentages['arr_' + file.id][1] = 1;
                } else if (cur === 'interrupt') {
                    showError('interrupt');
                } else if (cur === 'queued') {
                    percentages['arr_' + file.id][1] = 0;
                } else if (cur === 'progress') {
                    $info.remove();
                    $prgress.css('display', 'block');
                } else if (cur === 'complete') {
                    $li.append('<span class="success"></span>');
                }

                $li.removeClass('state-' + prev).addClass('state-' + cur);
            });

            $li.on('mouseenter', function () {
                $btns.stop().animate({height: 30});
            });

            $li.on('mouseleave', function () {
                $btns.stop().animate({height: 0});
            });

            $btns.on('click', 'span', function () {
                var index = $(this).index(),
                    deg;

                switch (index) {
                    case 0:
                        uploader_arr.removeFile(file);
                        return;

                    case 1:
                        file.rotation += 90;
                        break;

                    case 2:
                        file.rotation -= 90;
                        break;
                }

                if (supportTransition) {
                    deg = 'rotate(' + file.rotation + 'deg)';
                    $wrap.css({
                        '-webkit-transform': deg,
                        '-mos-transform': deg,
                        '-o-transform': deg,
                        'transform': deg
                    });
                } else {
                    $wrap.css('filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation=' + (~~((file.rotation / 90) % 4 + 4) % 4) + ')');
                    // use jquery animate to rotation
                    // $({
                    //     rotation: rotation
                    // }).animate({
                    //     rotation: file.rotation
                    // }, {
                    //     easing: 'linear',
                    //     step: function( now ) {
                    //         now = now * Math.PI / 180;

                    //         var cos = Math.cos( now ),
                    //             sin = Math.sin( now );

                    //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                    //     }
                    // });
                }


            });

            $li.appendTo($queue);
        }

        // 负责view的销毁
        function removeFile(file) {
            var $li = $('#arr_' + file.id);

            delete percentages['arr_' + file.id];
            updateTotalProgress();
            $li.off().find('.file-panel').off().end().remove();
        }

        function updateTotalProgress() {
            var loaded = 0,
                total = 0,
                spans = $progress.children(),
                percent;

            $.each(percentages, function (k, v) {
                total += v[0];
                loaded += v[0] * v[1];
            });

            percent = total ? loaded / total : 0;


            spans.eq(0).text(Math.round(percent * 100) + '%');
            spans.eq(1).css('width', Math.round(percent * 100) + '%');
            updateStatus();
        }

        function updateStatus() {
            var text = '', stats;

            if (state_arr === 'ready') {
                text = '选中' + fileCount + '张图片，共' +
                    WebUploader.formatSize(fileSize) + '。';
            } else if (state_arr === 'confirm') {
                stats = uploader_arr.getStats();
                if (stats.uploadFailNum) {
                    text = '已成功上传' + stats.successNum + '张照片至XX相册，' +
                        stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                }

            } else {
                stats = uploader_arr.getStats();
                text = '共' + fileCount + '张（' +
                    WebUploader.formatSize(fileSize) +
                    '），已上传' + stats.successNum + '张';

                if (stats.uploadFailNum) {
                    text += '，失败' + stats.uploadFailNum + '张';
                }
            }

            $info.html(text);
        }

        function setState(val) {
            var file, stats;

            if (val === state_arr) {
                return;
            }

            $upload_arr.removeClass('state-' + state_arr);
            $upload_arr.addClass('state-' + val);
            state_arr = val;
            var $filePicker2 = $('#filePicker2');

            switch (state_arr) {

                case 'pedding':
                    $placeHolder.removeClass('element-invisible');
                    $queue.hide();
                    $statusBar.addClass('element-invisible');
                    uploader_arr.refresh();
                    break;

                case 'ready':
                    $placeHolder.addClass('element-invisible');
                    $filePicker2.removeClass('element-invisible');
                    $queue.show();
                    $statusBar.removeClass('element-invisible');
                    uploader_arr.refresh();
                    break;

                case 'uploading':
                    $filePicker2.addClass('element-invisible');
                    $progress.show();
                    $upload_arr.text('暂停上传');
                    break;

                case 'paused':
                    $progress.show();
                    $upload_arr.text('继续上传');
                    break;

                case 'confirm':
                    $progress.hide();
                    $filePicker2.removeClass('element-invisible');
                    $upload_arr.text('开始上传');

                    stats = uploader_arr.getStats();
                    if (stats.successNum && !stats.uploadFailNum) {
                        setState('finish');
                        return;
                    }
                    break;
                case 'finish':
                    stats = uploader_arr.getStats();
                    if (stats.successNum) {
                        alert('上传成功');
                    } else {
                        // 没有成功的图片，重设
                        state_arr = 'done';
                        location.reload();
                    }
                    break;
            }

            updateStatus();
        }

        uploader_arr.onUploadProgress = function (file, percentage) {
            var $li = $('#arr_' + file.id),
                $percent = $li.find('.progress span');

            $percent.css('width', percentage * 100 + '%');
            percentages['arr_' + file.id][1] = percentage;
            updateTotalProgress();
        };

        uploader_arr.onFileQueued = function (file) {
            fileCount++;
            fileSize += file.size;

            if (fileCount === 1) {
                $placeHolder.addClass('element-invisible');
                $statusBar.show();
            }

            addFile(file);
            setState('ready');
            updateTotalProgress();
        };

        uploader_arr.onFileDequeued = function (file) {
            fileCount--;
            fileSize -= file.size;

            if (!fileCount) {
                setState('pedding');
            }

            removeFile(file);
            updateTotalProgress();

        };

        uploader_arr.on('all', function (type) {
            var stats;
            switch (type) {
                case 'uploadFinished':
                    setState('confirm');
                    break;

                case 'startUpload':
                    setState('uploading');
                    break;

                case 'stopUpload':
                    setState('paused');
                    break;

            }
        });

        uploader_arr.on('uploadSuccess', function (file, ret) {
            console.log(file, ret);
            console.log("上传成功的图片:", uploader_arr.getFiles('success'), uploader_arr.getFiles())    // => all error files.

            var img = ret.ret;
            $('#' + file.id).addClass('border-red');
//                var $li = $(
//                    '<div id="' + file.id + '" class="item">' +
//                    '<div class="pic-box"><img height="220px" src=' + img + '></div>' +
//                    '<div class="info">' + file.name + '</div>' +
//                    '</div>' + '<input class="hidden" name="wxqr" value="' + img + '"/>'
//                    ),
//                    $img = $li.find('img');
//                $list1.html($li);
        });

        uploader_arr.onError = function (code) {
            alert('Eroor: ' + code);
        };

        $upload_arr.on('click', function () {
            if ($(this).hasClass('disabled')) {
                return false;
            }

            if (state_arr === 'ready') {
                uploader_arr.upload();
            } else if (state_arr === 'paused') {
                uploader_arr.upload();
            } else if (state_arr === 'uploading') {
                uploader_arr.stop();
            }
        });

        $info.on('click', '.retry', function () {
            uploader_arr.retry();
        });

        $info.on('click', '.ignore', function () {
            alert('todo');
        });

        $upload_arr.addClass('state-' + state_arr);
        updateTotalProgress();
    }


</script>

</body>
</html>