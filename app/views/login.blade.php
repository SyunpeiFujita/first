<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ログイン</title>
<meta name="viewport" content="width=device-width,minimum-scale=1">
<link href={{ URL::to('tbs/css/bootstrap.min.css') }} rel="stylesheet">
<link href={{ URL::to('tbs/css/bootstrap-responsive.min.css') }} rel="stylesheet">
<link href={{ URL::to('tbs/css/mystyle.css') }} rel="stylesheet">
</head>
<body>
<div class="container" id="login-container">
<div class="ribbon">
<div class="ribbon-stitches-top">
</div>
<strong class="ribbon-content">
<div class="ribbon-stitches-bottom"></div></div>
{{ Form::open(array('class'=>'form-container')) }}
<div class="form-title"><h2>ログイン</h2></div>
{{ Form::label('username','ユーザー名',array('class'=>'form-title')) }}
{{ Form::text('username',Input::old('username',''),array('class'=>'form-field')) }}
@if($errors->has('username'))
<div class="form-title label label-important">
{{ $errors->first('username') }}
</div>
@endif
{{ Form::label('password','パスワード',array('class'=>'form-title')) }}
{{ Form::password('password',array('class'=>'form-field')) }}
@if($errors->has('password'))
<div class="form-title label label-important">
{{ $errors->first('password') }}
</div>
@endif
@if($errors->has('warning'))
<div class="alert alert-error" id="alert">
{{ $errors->first('warning') }}
</div>
@endif
<div class="submit-container">
{{ Form::submit('Login',array('class'=>'submit-button')) }}
</div>
{{ Form::token() }}
{{ Form::close() }}
</div>
<script src="http://code.jquery.com/jquery-1.9.1.min.js">
</script>
<script src={{ URL::to('tbs/js/bootstrap.min.js') }}></script>
</body>
</html>

