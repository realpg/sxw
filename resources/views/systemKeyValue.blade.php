@extends('include')
<html>

<table  class="tb">
    @foreach ($values as $value)
    <tr>
        <td class="tl"><span class="f_red">*</span> 标题</td>
        <td><input name="post[title]" type="text" id="title" size="60" value="{{$value->name}}"/> </td>
    </tr>
    @endforeach
</table>

</html>