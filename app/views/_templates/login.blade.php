@include('_includes/head')
<body class="login">
	<div class="page">
		<div class="main">
			<div class="login-form">
				<h1>@yield('pagetitle')</h1>
				@yield('primary')
			</div>
		</div>
	</div>
	<script src="js/jquery-1.8.0.min.js"></script>
	<script>
		$(function(){
			
			if( 'placeholder' in $('input')[0] ){
				console.log('test');
				$('input[type=text], input[type=password]').each(function(){
					var input = $(this), 
						label = $(this).prev('label');
					input.attr('placeholder', label.text());
					label.remove();
				});
			}
		});
	</script>
</body>
</html>