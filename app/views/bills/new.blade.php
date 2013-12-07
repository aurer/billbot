@extends('_templates.default')

@section('pagetitle') Bills :: New @stop

@section('primary')

	{{ Form::open() }}
				
		<div class="field required error-{{ strBool($errors->has('title')) }}">
			{{ Form::label('title', 'Title') }}
			<div class="input">
				{{ Form::text('title', Input::old('title') ) }}
				{{ fieldError($errors, 'title') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('amount')) }}">
			{{ Form::label('amount', 'Amount') }}
			<div class="input">
				{{ Form::text('amount', Input::old('amount')) }}
				{{ fieldError($errors, 'amount') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('recurrence')) }}">
			{{ Form::label('recurrence', 'Recurrence') }}
			<div class="input">
				{{ Form::select('recurrence', array('monthly'=>'Monthly', 'yearly'=>'Yearly', 'weekly'=>'Weekly') , Input::old('recurrence')) }}
				{{ fieldError($errors, 'recurrence') }}
			</div>
		</div>

		<div class="field required error-{{ strBool($errors->has('renews_on')) }}">
			{{ Form::label('renews_on', 'Renews on') }}
			<div class="input">
				{{ Form::text('renews_on', Input::old('renews_on')) }}
				{{ fieldError($errors, 'renews_on') }}
			</div>
		</div>

		<div class="field checkbox error-{{ strBool($errors->has('send_reminder')) }}">
			{{ Form::label('send_reminder', 'Send reminder?') }}
			<div class="input">
				{{ Form::checkbox('send_reminder', 'true', Input::old('send_reminder') ? true : false )}}
				{{ fieldError($errors, 'send_reminder') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('reminder')) }}">
			{{ Form::label('reminder', 'Send reminder this many days before') }}
			<div class="input">
				{{ Form::text('reminder', Input::old('reminder')) }}
				{{ fieldError($errors, 'reminder') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('comments')) }}">
			{{ Form::label('comments', 'Comments') }}
			<div class="input">
				{{ Form::textarea('comments', Input::old('comments')) }}
				{{ fieldError($errors, 'comments') }}
			</div>
		</div>
		
		<a class="btn" href="/{{ Request::segment(1) }}">Cancel</a>
		
		<input type="submit" class="btn submit" value="Add">
	
	{{ Form::close() }}

@stop

@section('head')
	{{ HTML::style('assets/plugins/jquery-ui-1.10.3.custom/css/ui-darkness/jquery-ui-1.10.3.custom.min.css') }}
@stop

@section('scripts')
	{{ HTML::script('assets/plugins/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.js') }}
	{{ HTML::script('assets/js/bill-forms.js') }}
@stop
