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
                <input type="text" class="input-text" value="{{$data->id?$data->id:''}}" placeholder=""
                       id="tagid" name="tagid">
            </div>
        </div>



        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>同义词表：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="content" cols="" rows="" class="textarea" placeholder="多个同义词用 = 连接"
                          datatype="*10-100" dragonfly="true" nullmsg="不能为空！"
                          onKeyUp="">{{$data->content?$data->content:''}}</textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/140</p>
            </div>
        </div>


        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button onClick="thesauru_save_submit();" class="btn btn-primary radius" type="button"><i
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

{{--<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('js/doT.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/static/h-ui.admin/js/H-ui.admin.js') }}"></script>--}}
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/layer/2.4/layer.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/static/h-ui/js/H-ui.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/webuploader/0.1.5/webuploader.min.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/ueditor/1.4.3/ueditor.config.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/ueditor/1.4.3/ueditor.all.min.js')}}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('hui/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js')}}"></script>--}}
<script type="text/javascript" src="{{ URL::asset('hui/bootstrapSwitch.js')}}"></script>
<script>
    //    $('#create-switch').wrap('<div class="switch" />').parent().bootstrapSwitch();
    function thesauru_save_submit() {
        $.post({
            url: '',
            data: $("form").serialize(),
            success: function (ret) {
                var index = parent.layer.getFrameIndex(window.name);
                parent.Hui_alert(ret.message, 2000);
                parent.refresh();
                console.log(ret,ret.ret, typeof(ret));
                if (ret.result) {
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
        parent.refresh();
        parent.$('.btn-refresh').click();
    }
</script>
</body>
</html>