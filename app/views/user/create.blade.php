@extends('layouts.master')
@section('navigation')
&nbsp;@parent
&nbsp;<li><a href={{ URL::to('user') }}>ユーザー一覧</a></li>
@stop
@section('content')
<h4>新規ユーザーを作成します</h4>
{{ Form::open(array('class'=>'form-horizontal')) }}
&nbsp;<div class="control-group">
{{ Form::label('username','ユーザー名',array('class'=>'control-label')) }}
&nbsp;<div class="controls">
{{ Form::text('username') }}
@if($errors->has('username'))
</div>
<div class="controls label label-important">
{{ $errors->first('username') }}
@endif
&nbsp;</div>
</div>
&nbsp;<div class="control-group">
{{ Form::label('email','Eメールアドレス',array('class'=>'control-label')) }}
&nbsp;<div class="controls">
{{ Form::text('email') }}
@if($errors->has('email'))
</div>
<div class="controls label label-important">
&nbsp;{{ $errors->first('email') }}
@endif
</div>
</div>
&nbsp;<div class="control-group">
{{ Form::label('password','パスワード',array('class'=>'control-label')) }}
&nbsp;<div class="controls">
{{ Form::password('password') }}
@if($errors->has('password'))
</div>
<div class="controls label label-important">
&nbsp;{{ $errors->first('password') }}
@endif
</div>
</div>
&nbsp;<div class="form-actions">
&nbsp;{{ Form::submit('登録メール送信',array('class'=>'btn btn-primary')) }}
&nbsp;</div>
{{ Form::token() }}
{{ Form::close() }}
@stop