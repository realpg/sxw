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
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-article-add" method="post">
        {{csrf_field()}}
        <div class="row cl hidden">
            <label class="form-label col-xs-4 col-sm-2">id：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$data->itemid?$data->itemid:''}}" placeholder=""
                       id="itemid" name="itemid">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$data->desc?$data->desc:''}}" placeholder=""
                       id="articletitle2" name="desc">
            </div>
        </div>

        <div class="row cl hidden">
            <label class="form-label col-xs-4 col-sm-2">xcx_pid：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$data->xcx_pid?$data->xcx_pid:$adplace->pid}}"
                       placeholder=""
                       id="xcx_pid" name="xcx_pid">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>价格1：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" step="1" min="0" class="input-text" value="{{$data->amount0?$data->amount0:''}}"
                       placeholder=""
                       id="amount0" name="amount0">积分/
                <input type="number" step="1" min="0" class="input-text" value="{{$data->druation0?$data->druation0/86400:''}}"
                                                            placeholder=""
                                                            id="druation0" name="druation0">天
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>价格2：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" step="1" min="0" class="input-text" value="{{$data->amount1?$data->amount1:''}}"
                       placeholder=""
                       id="amount1" name="amount1">积分/
                <input type="number" step="1" min="0" class="input-text" value="{{$data->druation1?$data->druation1/86400:''}}"
                       placeholder=""
                       id="druation1" name="druation1">天
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>价格3：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" step="1" min="0" class="input-text" value="{{$data->amount2?$data->amount2:''}}"
                       placeholder=""
                       id="amount2" name="amount2">积分/
                <input type="number" step="1" min="0" class="input-text" value="{{$data->druation2?$data->druation2/86400:''}}"
                       placeholder=""
                       id="druation2" name="druation2">天
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">展示类型：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select id="type" class="select" name="type" size="1">
				@if(substr_count($adplace->types,'0'))
                    <option value="0" {{$data->type==0?'selected':''}}>图片</option>@endif
                @if(substr_count($adplace->types,'1'))
                    <option value="1" {{$data->type==1?'selected':''}}>名片 </option>@endif
                @if(substr_count($adplace->types,'2'))
                    <option value="2" {{$data->type==2?'selected':''}}>信息</option>@endif
			</select>
			</span></div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">链接类型：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select id="linktype" class="select" name="linktype" size="1">
                <option id="linktype_1" value="1" {{$data->linktype==1?'selected':''}}>名片 </option>
                <option id="linktype_2" value="2" {{$data->linktype==2?'selected':''}}>信息</option>
                <option id="linktype_3" value="3" {{$data->linktype==3?'selected':''}}>外部链接</option>
                <option id="linktype_4" value="4" {{$data->linktype==4?'selected':''}}>客服</option>
			</select>
			</span></div>
        </div>

        <div class="row cl type type-0 @if($data->type!=0) hidden @endif">
            <label class="form-label col-xs-4 col-sm-2">图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container">
                    @if($data->img==''||$data->img==null)
                        <div id="fileList" class="uploader-list">
                        </div>
                        <div id="filePicker">选择图片</div>
                        <div id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">开始上传</div>
                    @else
                        <div id="fileList" class="uploader-list">
                            <div id="file.id'" class="item">
                                <div class="pic-box" id="filePicker"><img src='{{$data->img}}'></div>
                                <div class="info"></div>
                            </div>
                            <input class="hidden" name="img" value="{{$data->img}}"/>
                        </div>
                        <div id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">重新上传</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row cl linktype linktype-1 @if($data->linktype!=1) hidden @endif">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>关联名片用户id：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" min="1" step="1" class="input-text" value="{{$data->userid?$data->userid:''}}"
                       placeholder=""
                       id="articletitle2" name="userid">
            </div>
        </div>

        <div class="row cl linktype linktype-2 @if($data->linktype!=2) hidden @endif">
            <label class="form-label col-xs-4 col-sm-2">信息模块：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="item_mid" size="1">
				<option value="5" {{$data->item_mid==5?'selected':''}}>供应</option>
				<option value="6" {{$data->item_mid==6?'selected':''}}>求购</option>
				<option value="88" {{$data->item_mid==88?'selected':''}}>纺机贸易</option>
                {{--<option value="3">栏目编辑</option>--}}
			</select>
			</span></div>
        </div>

        <div class="row cl linktype linktype-2 @if($data->linktype!=2) hidden @endif">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>关联信息id：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" min="1" step="1" class="input-text" value="{{$data->item_id?$data->item_id:''}}"
                       placeholder=""
                       id="articletitle2" name="item_id">
            </div>
        </div>

        <div class="row cl linktype linktype-3 @if($data->linktype!=3) hidden @endif">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>外部链接：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="{{$data->url?$data->url:''}}" placeholder=""
                       id="articletitle2" name="url">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">排序值：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="number" class="input-text" value="{{$data->listorder?$data->listorder:0}}" placeholder=""
                       id="articlesort" name="listorder">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">有效期：</label>
            <div class="formControls col-xs-8 col-sm-9 bs-docs-example">

                <input name='fromtime' type="text" value="{{getPRCdate($data->fromtime?$data->fromtime:0,"Y-m-d")}}"
                       onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin"
                       class="input-text Wdate" style="width:120px;">
                -
                <input name='totime' type="text" value="{{getPRCdate($data->totime?$data->totime:0,"Y-m-d")}}"
                       onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}' })" id="logmax"
                       class="input-text Wdate" style="width:120px;">

            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">统计点击次数：</label>
            <div class="formControls col-xs-8 col-sm-9 bs-docs-example">
                <div class="switch">
                    <input id="create-switch" name="stat" type="checkbox"
                           value="1" {{$data->stat==1?'checked':''}}/>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">展示状态：</label>
            <div class="formControls col-xs-8 col-sm-9 bs-docs-example">
                <div class="switch">
                    <input id="create-switch" name="status" type="checkbox"
                           value="3" {{$data->status==3?'checked':''}}/>
                </div>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">出售状态：</label>
            <div class="formControls col-xs-8 col-sm-9 bs-docs-example">
                <div class="switch">
                    <input id="create-switch" name="onsell" type="checkbox"
                           value="1" {{$data->onsell==1?'checked':''}}/>
                </div>
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


<script type="text/javascript" src="{{ URL::asset('hui/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/laypage/1.2/laypage.js')}}"></script>

<script>
    //    $('#create-switch').wrap('<div class="switch" />').parent().bootstrapSwitch();
    function save_submit() {
        $.post({
            url: '',
            data: $("form").serialize(),
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

    $("#type").on("change", function () {
        var $this = $(this);
        console.log($this.val())
        switch ($this.val()) {
            case "0": {
                $("#linktype_1").removeClass("hidden");
                $("#linktype_2").removeClass("hidden");
                $("#linktype_3").removeClass("hidden");
                $("#linktype_4").removeClass("hidden");
                $(".type-0").removeClass("hidden");
                break;
            }
            case "1": {
                $("#linktype").val("1");
                $("#linktype_1").removeClass("hidden");
                $("#linktype_2").addClass("hidden");
                $("#linktype_3").addClass("hidden");
                $("#linktype_4").addClass("hidden");
                $(".type-0").addClass("hidden");
                break;
            }
            case "2": {
                $("#linktype").val("2");
                $("#linktype_1").addClass("hidden");
                $("#linktype_2").removeClass("hidden");
                $("#linktype_3").addClass("hidden");
                $("#linktype_4").addClass("hidden");
                $(".type-0").addClass("hidden");
                break;
            }
        }
    });
    $("#linktype").on("change", function () {
        console.log($(this).val())
        linktypeChange($(this).val());
    });

    function linktypeChange(val) {
        switch (val) {
            case "1": {
                $(".linktype").addClass("hidden");
                $(".linktype-1").removeClass("hidden");
                break;
            }
            case "2": {
                $(".linktype").addClass("hidden");
                $(".linktype-2").removeClass("hidden");
                break;
            }
            case "3": {
                $(".linktype").addClass("hidden");
                $(".linktype-3").removeClass("hidden");
                break;
            }
            case "4": {
                $(".linktype").addClass("hidden");
                $(".linktype-4").removeClass("hidden");
                break;
            }
        }
    }


    $(function () {
//        $('.skin-minimal input').iCheck({
//            checkboxClass: 'icheckbox-blue',
//            radioClass: 'iradio-blue',
//            increaseArea: '20%'
//        });

        linktypeChange($("#linktype").val());

        $list = $("#fileList"),
            $btn = $("#btn-star"),
            state = "pending",
            uploader;

        var uploader = WebUploader.create({
            auto: true,
            swf: "{{ URL::asset('hui/lib/webuploader/0.1.5/Uploader.swf')}}",

            // 文件接收服务端。
            server: "{{ URL::asset('upload')}}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {id: '#filePicker'},
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
        uploader.on('fileQueued', function (file) {
            var $li = $(
                '<div id="' + file.id + '" class="item">' +
                '<div class="pic-box"><img></div>' +
                '<div class="info">' + file.name + '</div>' +
                '<p class="state">等待上传...</p>' +
                '</div>'
                ),
                $img = $li.find('img');
            $list.html($li);

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr('src', src);
            }, thumbnailWidth, thumbnailHeight);
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
            var $li = $('#' + file.id),
                $percent = $li.find('.progress-box .sr-only');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo($li).find('.sr-only');
            }
            $li.find(".state").text("上传中");
            $percent.css('width', percentage * 100 + '%');
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, ret) {
            console.log(file, ret);
            var img = ret.ret;
            $('#' + file.id).addClass('upload-state-success').find(".state").text("已上传");
            var $li = $(
                '<div id="' + file.id + '" class="item">' +
                '<div class="pic-box"><img src=' + img + '></div>' +
                '<div class="info">' + file.name + '</div>' +
                '</div>' + '<input class="hidden" name="img" value="' + img + '"/>'
                ),
                $img = $li.find('img');
            $list.html($li);
        });

        // 文件上传失败，显示上传出错。
        uploader.on('uploadError', function (file) {
            $('#' + file.id).addClass('upload-state-error').find(".state").text("上传出错");
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function (file) {
            $('#' + file.id).find('.progress-box').fadeOut();
        });
        uploader.on('all', function (type) {
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

        $btn.on('click', function () {
            if (state === 'uploading') {
                uploader.stop();
            } else {
                uploader.upload();
            }
        });

    });
    /*
        (function( $ ){
            // 当domReady的时候开始初始化
            $(function() {
                var $wrap = $('.uploader-list-container'),

                    // 图片容器
                    $queue = $( '<ul class="filelist"></ul>' )
                        .appendTo( $wrap.find( '.queueList' ) ),

                    // 状态栏，包括进度和控制按钮
                    $statusBar = $wrap.find( '.statusBar' ),

                    // 文件总体选择信息。
                    $info = $statusBar.find( '.info' ),

                    // 上传按钮
                    $upload = $wrap.find( '.uploadBtn' ),

                    // 没选择文件之前的内容。
                    $placeHolder = $wrap.find( '.placeholder' ),

                    $progress = $statusBar.find( '.progress' ).hide(),

                    // 添加的文件数量
                    fileCount = 0,

                    // 添加的文件总大小
                    fileSize = 0,

                    // 优化retina, 在retina下这个值是2
                    ratio = window.devicePixelRatio || 1,

                    // 缩略图大小
                    thumbnailWidth = 110 * ratio,
                    thumbnailHeight = 110 * ratio,

                    // 可能有pedding, ready, uploading, confirm, done.
                    state = 'pedding',

                    // 所有文件的进度信息，key为file id
                    percentages = {},
                    // 判断浏览器是否支持图片的base64
                    isSupportBase64 = ( function() {
                        var data = new Image();
                        var support = true;
                        data.onload = data.onerror = function() {
                            if( this.width != 1 || this.height != 1 ) {
                                support = false;
                            }
                        }
                        data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                        return support;
                    } )(),

                    // 检测是否已经安装flash，检测flash的版本
                    flashVersion = ( function() {
                        var version;

                        try {
                            version = navigator.plugins[ 'Shockwave Flash' ];
                            version = version.description;
                        } catch ( ex ) {
                            try {
                                version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                    .GetVariable('$version');
                            } catch ( ex2 ) {
                                version = '0.0';
                            }
                        }
                        version = version.match( /\d+/g );
                        return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );
                    } )(),

                    supportTransition = (function(){
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
                    uploader;

                if ( !WebUploader.Uploader.support('flash') && WebUploader.browser.ie ) {

                    // flash 安装了但是版本过低。
                    if (flashVersion) {
                        (function(container) {
                            window['expressinstallcallback'] = function( state ) {
                                switch(state) {
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
                                'x-shockwave-flash" data="' +  swf + '" ';

                            if (WebUploader.browser.ie) {
                                html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                            }

                            html += 'width="100%" height="100%" style="outline:0">'  +
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
                    alert( 'Web Uploader 不支持您的浏览器！');
                    return;
                }

                // 实例化
                uploader = WebUploader.create({
                    pick: {
                        id: '#filePicker-2',
                        label: '点击选择图片'
                    },
                    formData: {
                        uid: 123,
                        _token:"{{csrf_token()}}"
                },
                dnd: '#dndArea',
                paste: '#uploader',
                swf: "{{ URL::asset('hui/lib/webuploader/0.1.5/Uploader.swf')}}",
                chunked: false,
                chunkSize: 512 * 1024,
                server:  "{{ URL::asset('upload')}}",
                // runtimeOrder: 'flash',

                // accept: {
                //     title: 'Images',
                //     extensions: 'gif,jpg,jpeg,bmp,png',
                //     mimeTypes: 'image/*'
                // },

                // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
                disableGlobalDnd: true,
                fileNumLimit: 300,
                fileSizeLimit: 200 * 1024 * 1024,    // 200 M
                fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M
            });

            // 拖拽时不接受 js, txt 文件。
            uploader.on( 'dndAccept', function( items ) {
                var denied = false,
                    len = items.length,
                    i = 0,
                    // 修改js类型
                    unAllowed = 'text/plain;application/javascript ';

                for ( ; i < len; i++ ) {
                    // 如果在列表里面
                    if ( ~unAllowed.indexOf( items[ i ].type ) ) {
                        denied = true;
                        break;
                    }
                }

                return !denied;
            });

            uploader.on('dialogOpen', function() {
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
            uploader.addButton({
                id: '#filePicker2',
                label: '继续添加'
            });

            uploader.on('ready', function() {
                window.uploader = uploader;
            });

            // 当有文件添加进来时执行，负责view的创建
            function addFile( file ) {
                var $li = $( '<li id="' + file.id + '">' +
                    '<p class="title">' + file.name + '</p>' +
                    '<p class="imgWrap"></p>'+
                    '<p class="progress"><span></span></p>' +
                    '</li>' ),

                    $btns = $('<div class="file-panel">' +
                        '<span class="cancel">删除</span>' +
                        '<span class="rotateRight">向右旋转</span>' +
                        '<span class="rotateLeft">向左旋转</span></div>').appendTo( $li ),
                    $prgress = $li.find('p.progress span'),
                    $wrap = $li.find( 'p.imgWrap' ),
                    $info = $('<p class="error"></p>'),

                    showError = function( code ) {
                        switch( code ) {
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

                        $info.text( text ).appendTo( $li );
                    };

                if ( file.getStatus() === 'invalid' ) {
                    showError( file.statusText );
                } else {
                    // @todo lazyload
                    $wrap.text( '预览中' );
                    uploader.makeThumb( file, function( error, src ) {
                        var img;

                        if ( error ) {
                            $wrap.text( '不能预览' );
                            return;
                        }

                        if( isSupportBase64 ) {
                            img = $('<img src="'+src+'">');
                            $wrap.empty().append( img );
                        } else {
                            $.ajax('lib/webuploader/0.1.5/server/preview.php', {
                                method: 'POST',
                                data: src,
                                dataType:'json'
                            }).done(function( response ) {
                                if (response.result) {
                                    img = $('<img src="'+response.result+'">');
                                    $wrap.empty().append( img );
                                } else {
                                    $wrap.text("预览出错");
                                }
                            });
                        }
                    }, thumbnailWidth, thumbnailHeight );

                    percentages[ file.id ] = [ file.size, 0 ];
                    file.rotation = 0;
                }

                file.on('statuschange', function( cur, prev ) {
                    if ( prev === 'progress' ) {
                        $prgress.hide().width(0);
                    } else if ( prev === 'queued' ) {
                        $li.off( 'mouseenter mouseleave' );
                        $btns.remove();
                    }

                    // 成功
                    if ( cur === 'error' || cur === 'invalid' ) {
                        console.log( file.statusText );
                        showError( file.statusText );
                        percentages[ file.id ][ 1 ] = 1;
                    } else if ( cur === 'interrupt' ) {
                        showError( 'interrupt' );
                    } else if ( cur === 'queued' ) {
                        percentages[ file.id ][ 1 ] = 0;
                    } else if ( cur === 'progress' ) {
                        $info.remove();
                        $prgress.css('display', 'block');
                    } else if ( cur === 'complete' ) {
                        $li.append( '<span class="success"></span>' );
                    }

                    $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
                });

                $li.on( 'mouseenter', function() {
                    $btns.stop().animate({height: 30});
                });

                $li.on( 'mouseleave', function() {
                    $btns.stop().animate({height: 0});
                });

                $btns.on( 'click', 'span', function() {
                    var index = $(this).index(),
                        deg;

                    switch ( index ) {
                        case 0:
                            uploader.removeFile( file );
                            return;

                        case 1:
                            file.rotation += 90;
                            break;

                        case 2:
                            file.rotation -= 90;
                            break;
                    }

                    if ( supportTransition ) {
                        deg = 'rotate(' + file.rotation + 'deg)';
                        $wrap.css({
                            '-webkit-transform': deg,
                            '-mos-transform': deg,
                            '-o-transform': deg,
                            'transform': deg
                        });
                    } else {
                        $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
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

                $li.appendTo( $queue );
            }

            // 负责view的销毁
            function removeFile( file ) {
                var $li = $('#'+file.id);

                delete percentages[ file.id ];
                updateTotalProgress();
                $li.off().find('.file-panel').off().end().remove();
            }

            function updateTotalProgress() {
                var loaded = 0,
                    total = 0,
                    spans = $progress.children(),
                    percent;

                $.each( percentages, function( k, v ) {
                    total += v[ 0 ];
                    loaded += v[ 0 ] * v[ 1 ];
                } );

                percent = total ? loaded / total : 0;


                spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
                spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
                updateStatus();
            }

            function updateStatus() {
                var text = '', stats;

                if ( state === 'ready' ) {
                    text = '选中' + fileCount + '张图片，共' +
                        WebUploader.formatSize( fileSize ) + '。';
                } else if ( state === 'confirm' ) {
                    stats = uploader.getStats();
                    if ( stats.uploadFailNum ) {
                        text = '已成功上传' + stats.successNum+ '张照片至XX相册，'+
                            stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                    }

                } else {
                    stats = uploader.getStats();
                    text = '共' + fileCount + '张（' +
                        WebUploader.formatSize( fileSize )  +
                        '），已上传' + stats.successNum + '张';

                    if ( stats.uploadFailNum ) {
                        text += '，失败' + stats.uploadFailNum + '张';
                    }
                }

                $info.html( text );
            }

            function setState( val ) {
                var file, stats;

                if ( val === state ) {
                    return;
                }

                $upload.removeClass( 'state-' + state );
                $upload.addClass( 'state-' + val );
                state = val;

                switch ( state ) {
                    case 'pedding':
                        $placeHolder.removeClass( 'element-invisible' );
                        $queue.hide();
                        $statusBar.addClass( 'element-invisible' );
                        uploader.refresh();
                        break;

                    case 'ready':
                        $placeHolder.addClass( 'element-invisible' );
                        $( '#filePicker2' ).removeClass( 'element-invisible');
                        $queue.show();
                        $statusBar.removeClass('element-invisible');
                        uploader.refresh();
                        break;

                    case 'uploading':
                        $( '#filePicker2' ).addClass( 'element-invisible' );
                        $progress.show();
                        $upload.text( '暂停上传' );
                        break;

                    case 'paused':
                        $progress.show();
                        $upload.text( '继续上传' );
                        break;

                    case 'confirm':
                        $progress.hide();
                        $( '#filePicker2' ).removeClass( 'element-invisible' );
                        $upload.text( '开始上传' );

                        stats = uploader.getStats();
                        if ( stats.successNum && !stats.uploadFailNum ) {
                            setState( 'finish' );
                            return;
                        }
                        break;
                    case 'finish':
                        stats = uploader.getStats();
                        if ( stats.successNum ) {
                            alert( '上传成功' );
                        } else {
                            // 没有成功的图片，重设
                            state = 'done';
                            location.reload();
                        }
                        break;
                }

                updateStatus();
            }

            uploader.onUploadProgress = function( file, percentage ) {
                var $li = $('#'+file.id),
                    $percent = $li.find('.progress span');

                $percent.css( 'width', percentage * 100 + '%' );
                percentages[ file.id ][ 1 ] = percentage;
                updateTotalProgress();
            };

            uploader.onFileQueued = function( file ) {
                fileCount++;
                fileSize += file.size;

                if ( fileCount === 1 ) {
                    $placeHolder.addClass( 'element-invisible' );
                    $statusBar.show();
                }

                addFile( file );
                setState( 'ready' );
                updateTotalProgress();
            };

            uploader.onFileDequeued = function( file ) {
                fileCount--;
                fileSize -= file.size;

                if ( !fileCount ) {
                    setState( 'pedding' );
                }

                removeFile( file );
                updateTotalProgress();

            };

            uploader.on( 'all', function( type ) {
                var stats;
                switch( type ) {
                    case 'uploadFinished':
                        setState( 'confirm' );
                        break;

                    case 'startUpload':
                        setState( 'uploading' );
                        break;

                    case 'stopUpload':
                        setState( 'paused' );
                        break;

                }
            });

            uploader.onError = function( code ) {
                alert( 'Eroor: ' + code );
            };

            $upload.on('click', function() {
                if ( $(this).hasClass( 'disabled' ) ) {
                    return false;
                }

                if ( state === 'ready' ) {
                    uploader.upload();
                } else if ( state === 'paused' ) {
                    uploader.upload();
                } else if ( state === 'uploading' ) {
                    uploader.stop();
                }
            });

            $info.on( 'click', '.retry', function() {
                uploader.retry();
            } );

            $info.on( 'click', '.ignore', function() {
                alert( 'todo' );
            } );

            $upload.addClass( 'state-' + state );
            updateTotalProgress();
        });

    })( jQuery );
*/
    //    $(function () {
    //        var ue = UE.getEditor('editor');
    //    });
</script>


</body>
</html>