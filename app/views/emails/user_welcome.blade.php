@extends('_templates.email')

@section('primary')
	<h1>Welcome to Billbot</h1>
	<h2>Thanks for joining us</h2>
	<hr style="border:none; border-top: 1px solid #333">
	<p>Hi {{ $user->username }},</p>
	<p>You can either copy and paste the code below into the registration form:</p>
	<pre style="font-size:1em;background:#eee;">{{ $user->hash }}</pre>
	<p>or click following link <a href="{{ Request::root() }}/user/confirm?hash={{ $user->hash }}">{{ Request::root() }}/user/confirm?hash={{ $user->hash }}</a></p>
@stop