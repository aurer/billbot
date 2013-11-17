@extends('_templates.form-page')

@section('pagetitle') Forgotten password @stop

@section('primary')
	
	@if( Session::has('success') )
		<p class="success">{{ Session::get('success') }}</p>
	@endif

	{{ Form::open() }}

		<div class="field required">
			{{ Form::label('email', 'Email') }}
			<div class="input">
				{{ Form::text('email', Input::old('email')) }}
			</div>
			{{ $errors->has('email') ? $errors->first('email', '<p class="error">:message</p>') : '' }}
		</div>

		<input type="submit" class="btn submit" value="Send">
		<a class="btn" href="/">Home</a>

	{{ Form::close() }}

@stop