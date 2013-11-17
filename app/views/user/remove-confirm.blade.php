@extends('_templates.message')

@section('primary')
	<h2>Are you sure you want to remove your account?</h2>
	<p>We'll remove all your data and their ain't no getting it back.</p>
	<form action="/user/remove" method="post">
		<button class="btn">Yes, remove my data</button>
	</form>
@stop