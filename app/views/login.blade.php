{{ Form::open() }}
{{ Form::label('username', 'ユーザー名：') }}
{{ Form::text('username', Input::old('username', '')) }}
<br>
{{ Form::label('password', 'パスワード：') }}
{{ Form::password('password') }}
<br>
{{ Form::submit('ログイン'); }}
{{ Form::close() }}
