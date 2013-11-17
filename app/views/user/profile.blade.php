@extends('_templates.form-page')

@section('pagetitle') Your Details @stop

@section('primary')
	
	@if( Session::has('success') )
		<p class="success">{{ Session::get('success') }}</p>
	@endif

	{{ Form::open() }}

		<div class="field required">
			{{ Form::label('username', 'Username') }}
			<div class="input">
				{{ Form::text('username', $data->username) }}
			</div>
			{{ $errors->has('username') ? $errors->first('username', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('forename', 'Forename') }}
			<div class="input">
				{{ Form::text('forename', $data->forename) }}
			</div>
			{{ $errors->has('forename') ? $errors->first('forename', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('surname', 'Surname') }}
			<div class="input">
				{{ Form::text('surname', $data->surname) }}
			</div>
			{{ $errors->has('surname') ? $errors->first('surname', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field required">
			{{ Form::label('email', 'Email') }}
			<div class="input">
				{{ Form::text('email', $data->email) }}
			</div>
			{{ $errors->has('email') ? $errors->first('email', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('password', 'Password') }}
			<div class="input">
				{{ Form::password('password') }}
			</div>
			{{ $errors->has('password') ? $errors->first('password', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('password_confirm', 'Confirm password') }}
			<div class="input">
				{{ Form::password('password_confirm') }}
			</div>
			{{ $errors->has('password_confirm') ? $errors->first('password_confirm', '<p class="error">:message</p>') : '' }}
		</div>
		
		<a class="btn" href="/"><i class="icon-">&#xf015;</i> Home</a>
		<a class="btn" href="/user/remove"><i class="icon-">&#xf00d;</i> Remove account</a>
		<button type="submit" class="btn submit"><i class="icon-">&#xf00c;</i> Save</button>

	{{ Form::close() }}

@stop