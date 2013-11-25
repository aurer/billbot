@extends('_templates.form-page')

@section('pagetitle') Check your email... @stop

@section('primary')
	<p>We sent you an email to confirm your email address.</p>
	<p><b>Please copy the provided key and paste it into the box below</b> or click the link in the email.</p>
	<form action="/user/reset-confirm">
		<div class="field required">
			{{ Form::label('hash', "Reference") }}
			<div class="input">
				{{ Form::text('hash') }}
			</div>
		</div>
		<div class="submit">
			{{ Form::submit('Confirm', array('class'=>'btn')) }}
		</div>
	</form>
	@if( Session::has('error') ) 
		<p class="error">{{ Session::get('error') }}</p> 
	@endif
@stop