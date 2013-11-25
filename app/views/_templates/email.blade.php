<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('pagetitle')</title>
	{{ HTML::style('assets/css/emails.css') }}
	@yield('head')
</head>
<body class="email">
	<table class="wrapper" border="0" cellpadding="10px" cellspacing="0" align="center" width="100%"><tr>
		<td>
			<table class="main" border="0" width="100%" align="center" cellpadding="0" cellspacing="0"><tr><td>
				<h1>@yield('pagetitle')</h1>
				@yield('primary')
				<hr style="border:none; border-top: 1px solid #333">
				@yield('foot')
				<p>Regards</p>
				<p><a href="http://billbot.aurer.co.uk">Billbot</a></p>
			</td></tr></table>
		</td>
	</tr></table>
</body>
</html>