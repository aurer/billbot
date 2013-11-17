@extends('_templates.login')

@section('pagetitle') Login @stop

@section('primary')
	@if( Auth::check() )
		You are already logged in, no need to be here.
	@endif
	@include('_includes.login')
@stop

@section('primary')
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
@stop