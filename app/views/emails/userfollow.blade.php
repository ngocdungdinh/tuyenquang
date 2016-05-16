@extends('emails/layouts/default')

@section('content')
<table border="0" cellpadding="20" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td valign="top" style="border-collapse: collapse;">
            	{{ User::avatar($user->avatar, '100x100_crop', 100) }}
            </td>
            <td valign="top" style="border-collapse: collapse;">
            	<h2 class="h2" style="color: #444;display: block;font-family: Arial;font-size: 22px;font-weight: normal; line-height: 30px;margin-top: 0;margin-right: 0;margin-bottom: 10px;margin-left: 0;text-align: left;"><a style="color: #4FA5E0;font-weight: normal;text-decoration: none;" href="/u/{{ $user->username}}">{{ $user->first_name }}</a> vừa quan tâm đến bạn trên Roadline.vn</h2>
            </td>
        </tr>
    </tbody>
</table>
<hr style="margin: 18px 0; border: 0; border-top: 1px solid #eeeeee; border-bottom: 1px solid #ffffff;" />
<div style="text-align: center; padding: 40px 0px; ">
	<a href="/u/{{ $user->username}}" style="text-decoration:none;color:#fff;padding:12px 25px;font-size:18px;background:#2f96b4;border-radius:3px;font-family:arial,sans-serif;margin:0;margin-top:0;margin-bottom:0;margin-left:0;margin-right:0" target="_blank"><span style="color:#fff">Xem trang cá nhân của <strong>{{ $user->first_name }}</strong></span></a>
</div>
@stop