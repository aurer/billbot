@extends('_templates.form-page')

@section('primary')
	
	<h1>Sign up</h1>

	{{ Form::open() }}

		<div class="field required">
			{{ Form::label('username', 'Username') }}
			<div class="input">
				{{ Form::text('username', Input::old('username')) }}
			</div>
			{{ $errors->has('username') ? $errors->first('username', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field required">
			{{ Form::label('email', 'Email') }}
			<div class="input">
				{{ Form::text('email', Input::old('email')) }}
			</div>
			{{ $errors->has('email') ? $errors->first('email', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field required">
			{{ Form::label('password', 'Password') }}
			<div class="input">
				{{ Form::password('password') }}
			</div>
			{{ $errors->has('password') ? $errors->first('password', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field required">
			{{ Form::label('password_confirm', 'Confirm password') }}
			<div class="input">
				{{ Form::password('password_confirm') }}
			</div>
			{{ $errors->has('password_confirm') ? $errors->first('password_confirm', '<p class="error">:message</p>') : '' }}
		</div>
		
		
		<div class="field submit">	
			<a class="btn" href="/">Cancel</a>
			<input type="submit" class="btn" value="Add">
		</div>
	{{ Form::close() }}

@stop