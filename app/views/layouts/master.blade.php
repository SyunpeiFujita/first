<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>藤田のサンプル</title>
<meta name="viewport" content="width=device-width,minimum-scale=1">
<link href={{ URL::to('tbs/css/bootstrap.min.css')}} rel="stylesheet">
<link href={{ URL::to('tbs/css/bootstrap-responsive.min.css')}} rel="stylesheet">
</head>
<body>
<div class="navbar">
<div class="navbar-inner">
<div class="ccontainer" align="center">
		<img src="/laravel/public/img/jojo.jpeg" alt="jojo"><br>
<a href="#" class="brand">WinRoad徒然草</a>
<ul class="nav">
 @section('navigation')
 <li><a href='#'>TOP</a></li>
 <li><a href='#'>UPDATE</a></li>
 @show
</ul>
</div>
</div>
</div>
<div class="container">
 @yield('content')
</div>
<script src="http://code.jquery.com/jquery-1.9.1.min.js">
</script>
<script src={{ URL::to('tbs/js/bootstrap.min.js') }}></script>
</body>
</html>
