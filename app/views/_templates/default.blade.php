@include('_includes/head')
<body class="default">
	<div class="page">
		<div class="header">
			@include('_includes.login')
		</div>
		<h1>@yield('pagetitle')</h1>
		<hr>
		<div class="main">
			<div class="primary">
				@yield('primary')
			</div>
			<div class="secondary"></div>
		</div>
		@include('_includes/foot')
	</div>
</body>
</html>