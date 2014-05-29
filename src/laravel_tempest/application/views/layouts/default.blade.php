<!doctype html>
<html>
<head>
	@yield('title')
	{{ HTML::style('css/style.css') }}
	@yield('include')
</head>

<body>
	<div id="header">
		<h1>Project Temp.e.s.t.</h1>
		<h3>CEAS Server Room Temperature Monitoring Center</h3>
		
		<div id="login">
		@if(Auth::user())
			<a>welcome, {{Auth::user()->username}}</a>
			<a>{{HTML::link('logout', 'logout')}}</a>
		@else
			<a>{{HTML::link('login', 'login')}}</a>
		@endif
		</div>

		<ul>
			<li> {{HTML::link('home', 'Home')}} </li>
			<li> {{HTML::link('details', 'Details')}} </li>
		</ul>
	</div>

	<div id="left_sidebar">
		<h3>At a Glance</h3>
		<div class="at_a_glance_menu">
			@yield('glance')
		</div>
	</div>
	<div id="main_content">	
		<div class="error">
			<h2>
				<?php  echo Session::get('error');  ?>
			</h2>
		</div>

		<div class="message">
			<h3>
				<?php  echo Session::get('message');  ?>
			</h3>
		</div>

		@yield('content')
	</div>

	<div id="footer">
	</div>
</body>
</html>
