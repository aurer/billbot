@extends('_templates.default')

@section('pagetitle') Bills :: New @stop

@section('primary')

	{{ Form::open() }}
				
		<div class="field required">
			{{ Form::label('title', 'Title') }}
			<div class="input">
				{{ Form::text('title', Input::old('title') ) }}
			</div>
			{{ $errors->has('title') ? $errors->first('title', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('amount', 'Amount') }}
			<div class="input">
				{{ Form::text('amount', Input::old('amount')) }}
			</div>
			{{ $errors->has('amount') ? $errors->first('amount', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('recurrence', 'Recurrence') }}
			<div class="input">
				{{ Form::select('recurrence', array('monthly'=>'Monthly', 'yearly'=>'Yearly', 'weekly'=>'Weekly') , Input::old('recurrence')) }}
			</div>
			{{ $errors->has('recurrence') ? $errors->first('recurrence', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field required">
			{{ Form::label('renews_on', 'Renews on') }}
			<div class="input">
				{{ Form::text('renews_on', Input::old('renews_on'), array('placeholder'=>'e.g. Saturday or 25th April')) }}
			</div>
			{{ $errors->has('renews_on') ? $errors->first('amount', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field checkbox">
			{{ Form::label('send_reminder', 'Send reminder?') }}
			<div class="input">
				{{ Form::checkbox('send_reminder', 'true', Input::old('send_reminder') ? true : false )}}
			</div>
			{{ $errors->has('send_reminder') ? $errors->first('send_reminder', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('reminder', 'Send reminder this many days before') }}
			<div class="input">
				{{ Form::text('reminder', Input::old('reminder')) }}
			</div>
			{{ $errors->has('reminder') ? $errors->first('reminder', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('comments', 'Comments') }}
			<div class="input">
				{{ Form::textarea('comments', Input::old('comments')) }}
			</div>
			{{ $errors->has('comments') ? $errors->first('comments', '<p class="error">:message</p>') : '' }}
		</div>
		
		<a class="btn" href="/{{ Request::segment(1) }}">Cancel</a>
		
		<input type="submit" class="btn submit" value="Add">
	
	{{ Form::close() }}

@stop

@section('scripts')
	{{ HTML::script('assets/js/bill-forms.js') }}
@stop