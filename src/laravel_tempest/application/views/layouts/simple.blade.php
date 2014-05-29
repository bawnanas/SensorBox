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
		<h3>CEAS Server Temperature Monitoring Center</h3>
		<ul>
		</ul>
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
