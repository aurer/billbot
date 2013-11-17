@extends('_templates.form-page')

@section('pagetitle') Create password @stop

@section('primary')
	
	@if(!$user)
		<div class="page-message">
			<p>Sorry but it looks like your reset link is invalid or has expired.</p>
			<p>You can request another reset here: <a href="/user/reset">Reset password</a>.</p>
		</div>
	@else
		<p>Enter your new password below</p>

		{{ Form::open( array('url' => Request::path()) ) }}

			<div class="field required">
				{{ Form::label('password', 'Password') }}
				{{ Form::password('password') }}
				{{ $errors->has('password') ? $errors->first('password', '<p class="error">:message</p>') : '' }}
			</div>
			<div class="field required">
				{{ Form::label('password_confirm', 'Confirm password') }}
				{{ Form::password('password_confirm') }}
				{{ $errors->has('password_confirm') ? $errors->first('password_confirm', '<p class="error">:message</p>') : '' }}
			</div>

			<div class="field submit">
				<input type="hidden" name="hash" value="{{ Input::get('hash') }}">
				<input type="submit" class="btn" value="Update password">
			</div>
		{{ Form::close() }}
	@endif

@stop