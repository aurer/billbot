@extends('_templates.error')

<?php $messages = array('We need a map.', 'I think we\'re lost.', 'We took a wrong turn.'); ?>
@section('pagetitle')
	{{ $messages[mt_rand(0, 2)] }}
@stop

@section('primary')
	<h2>Server Error: 500 (Internal Server Error)</h2>
	<hr>
	<h3>What does this mean?</h3>
	<p>
		Something went wrong on our servers while we were processing your request.
		We're really sorry about this, and will work hard to get this resolved as
		soon as possible.
	</p>
	<p>
		Perhaps you would like to go to our <?php echo HTML::link('/', 'home page'); ?>?
	</p>
@stop