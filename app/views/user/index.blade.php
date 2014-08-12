@extends('layouts.master')
@section('navigation')
 @parent
 <li><a href={{ URL::to('user/create') }}>新規作成</a></li>
 <li><a href={{ URL::to('logout') }}>ログアウト</a></li>
 @stop
 @section('content')
 <table class="table table-striped table-bordered">
 <tr>
 <th>id</th>
 <th>ユーザー名</th>
 <th>Eメールアドレス</th>
 <th>パスワード</th>
 <th>作成日</th>
 <th>更新日</th>
 <th>処理</th>
 </tr>
 @foreach($users as $user)
 <tr>
 <td>{{ $user->id }}</td>
 <td>{{ $user->username }}</td>
 <td>{{ $user->email }}</td>
 <td>{{ $user->password }}</td>
 <td>{{ $user->created_at }}</td>
 <td>{{ $user->updated_at }}</td>
 <td><i class="icon-pencil"></i>
 <a href="#">編集</a>
 <i class="icon-remove"></i>
 <a href={{ URL::to('user/delete/'.$user->id) }}>削除</a></td>
 </tr>
 @endforeach
 @stop