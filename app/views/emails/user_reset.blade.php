@extends('_templates.email')

@section('primary')
	<h2>Reset your password</h2>
	<hr style="border:none; border-top: 1px solid #333">
	<p>Hi {{ $user->username }},</p>
	<p>This email was sent to you because you requested a password reset, if you disn't request this, please ignore this email.</p>
	<p>You can either copy and paste the code below into the registration form:</p>
	<pre style="font-size:1em;background:#eee;">{{ $user->hash }}</pre>
	<p>or click following link <a href="{{ Request::root() }}/user/reset-confirm?hash={{ $user->hash }}">{{ Request::root() }}/user/reset-confirm?hash={{ $user->hash }}</a></p>
@stop