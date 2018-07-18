@extends('layouts.include')
@section('content')
    <article class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-member-add">
            @foreach ($values as $value)
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">{{$value->name}}</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        @if($value->type==1)
                            <input name="value" id='{{$value->id}}' class="switch-btn switch-btn-animbg" type="checkbox"
                                   @if($value->value==1) checked @endif/>
                        @elseif($value->type==2)

                            <textarea name="value" id='{{$value->id}}' cols="" rows="" class="textarea"
                                      placeholder="请填写">{{$value->value}}</textarea>

                            <input class="btn btn-primary radius submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                        @endif
                    </div>
                </div>
            @endforeach
        </form>
    </article>

    {{--<div class="p-10">--}}
        {{--<table class="tb">--}}
            {{--@foreach ($values as $value)--}}

                {{--<tr>--}}
                    {{--<td class="tl">{{$value->name}}</td>--}}
                    {{--@if($value->type==1)--}}
                        {{--<td><input name=value" id='{{$value->id}}' class="switch-btn switch-btn-animbg" type="checkbox"--}}
                                   {{--onchange="submit({id:'{{$value->id}}',value:this.checked?1:0,_token:'{{ csrf_token() }}'})"--}}
                                   {{--@if($value->value==1) checked @endif></td>--}}
                    {{--@elseif($value->type==2)--}}
                        {{--<td><textarea name="value" id='{{$value->id}}'--}}
                                      {{--style="width:90%;height:200px;">{{$value->value}}</textarea>--}}
                            {{--<button class="submit">提交</button>--}}
                        {{--</td>--}}
                    {{--@endif--}}
                {{--</tr>--}}
            {{--@endforeach--}}
        {{--</table>--}}

        {{--<button class="btn radius btn-primary size-L" onClick="modaldemo()">弹出对话框</button>--}}
    {{--</div>--}}

    <style>
        .switch-btn {
            cursor: pointer;
            width: 45px;
            height: 28px;
            position: relative;
            border: 1px solid #dfdfdf;
            background-color: #fdfdfd;
            box-shadow: #dfdfdf 0 0 0 0 inset;
            border-radius: 15px;
            background-clip: content-box;
            display: inline-block;
            -webkit-appearance: none;
            user-select: none;
            outline: none;
        }

        .switch-btn:before {
            content: '';
            width: 25px;
            height: 25px;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 20px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .4);
        }

        .switch-btn:checked {
            border-color: #56b0d4;
            box-shadow: #56b0d4 0 0 0 16px inset;
            background-color: #56b0d4;
        }

        .switch-btn:checked:before {
            left: 18px;
        }

        .switch-btn.switch-btn-animbg {
            transition: background-color ease .4s;
        }

        .switch-btn.switch-btn-animbg:before {
            transition: left .3s;
        }

        .switch-btn.switch-btn-animbg:checked {
            box-shadow: #dfdfdf 0 0 0 0 inset;
            background-color: #56b0d4;
            transition: border-color .4s, background-color ease .4s;
        }

        .switch-btn.switch-btn-animbg:checked:before {
            transition: left .3s;
        }
    </style>
@endsection

@section('script')
    <script type="text/javascript">
        $('.submit').on('click', function () {
            var param = {};
            param.id = $(this).prev().attr('id');
            param.value = $(this).prev().val();
            param._token = "{{ csrf_token() }}";
            console.log('请求参数', param, "{{url()->full()}}");
            submit(param);
        });
        $('.switch-btn').on('change', function () {
            var param = {};
            param.id = $(this).attr('id');
            param.value = $(this).val()?1:0;
            param._token = "{{ csrf_token() }}";
            console.log('请求参数', param, "{{url()->full()}}");
            submit(param);
        });

        function submit(param) {
            $.ajax({
                url: "{{url()->full()}}",
                type: 'POST',
                data: param,
                success: function (ret) {
                    console.log("ret is:", ret);
                    if (ret.result) {
                        toast.success({
                            title: "操作成功",
                            duration: 2000
                        });
                    } else {
                        toast.fail({
                            title: "提交失败",
                            duration: 2000
                        });
                    }
                }
            })
        }
    </script>
    </html>

@endsection