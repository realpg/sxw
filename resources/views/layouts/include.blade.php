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
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui/css/H-ui.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui/css/H-ui.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui.admin/css/H-ui.admin.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/lib/Hui-iconfont/1.0.8/iconfont.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui.admin/skin/default/skin.css')}}"
          id="skin"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('hui/static/h-ui.admin/css/style.css')}}"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="{{ URL::asset('hui/lib/DD_belatedPNG_0.0.8a-min.js')}}"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/app.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/aui.css') }}"/>
    {{--<link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/default/style.css') }}"/>--}}
    <title>纱线网小程序后台</title>
</head>
<body>


@yield('content')

<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery-3.3.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/aui-dialog.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('hui/lib/jquery/1.9.1/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/static/h-ui/js/H-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('hui/static/h-ui.admin/js/H-ui.admin.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    var dialog = new auiDialog();
    function modaldemo() {
        $("#modal-demo").modal("show")
    }

    function showDalog(callback){
        var dialog = new auiDialog();

        dialog.alert({
            title:"弹出提示",
            msg:'这里是内容',
        },function(ret){
            console.log(ret)
        })
    }

</script>
</body>
</html>

@yield('script')
