@extends('_templates.error')


@section('pagetitle')
	Error {{ $code }}
@stop

@section('primary')
	
	<div class="error-message">
		<h1>{{ $code }} {{ $status }}</h2>
		<p>{{ $message }}</p>
		<!-- {{  base64_encode($exception->getFile()) }} -->
	</div>
@stop