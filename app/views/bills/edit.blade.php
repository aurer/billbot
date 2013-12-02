@extends('_templates.default')

@section('pagetitle') Edit :: {{ $bill->title }} @stop

@section('primary')

	{{ Form::open() }}

		<div class="field required">
			{{ Form::label('title', 'Title') }}
			<div class="input">
				{{ Form::text('title', Input::old('title', $bill->title)  ) }}
			</div>
			{{ $errors->has('title') ? $errors->first('title', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('amount', 'Amount') }}
			<div class="input">
				{{ Form::text('amount', Input::old('amount', $bill->amount) ) }}
			</div>
			{{ $errors->has('amount') ? $errors->first('amount', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('recurrence', 'Recurrence') }}
			<div class="input">
				{{ Form::select('recurrence', array('monthly'=>'Monthly', 'yearly'=>'Yearly', 'weekly'=>'Weekly') , Input::old('recurrence', $bill->recurrence) ) }}
			</div>
			{{ $errors->has('recurrence') ? $errors->first('recurrence', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field required">
			{{ Form::label('renews_on', 'Renews on') }}
			<div class="input">
				{{ Form::text('renews_on', Input::old('renews_on', $bill->renews_on) ) }}
			</div>
			{{ $errors->has('renews_on') ? $errors->first('amount', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field checkbox">
			{{ Form::label('send_reminder', 'Send reminder?') }}
			<div class="input">
				{{ Form::checkbox('send_reminder', 'true', $bill->send_reminder ? true : false )}}
			</div>
			{{ $errors->has('send_reminder') ? $errors->first('send_reminder', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field checkbox">
			{{ Form::label('include_in_totals', 'Include in totals?') }}
			<div class="input">
				{{ Form::checkbox('include_in_totals', 'true', $bill->include_in_totals ? true : false )}}
			</div>
			{{ $errors->has('include_in_totals') ? $errors->first('include_in_totals', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('reminder', 'Remind me this many days before') }}
			<div class="input">
				{{ Form::input('number', 'reminder', Input::old('reminder', $bill->reminder) )}}
			</div>
			{{ $errors->has('reminder') ? $errors->first('reminder', '<p class="error">:message</p>') : '' }}
		</div>

		<div class="field">
			{{ Form::label('comments', 'Comments') }}
			<div class="input">
				{{ Form::textarea('comments', Input::old('comments', $bill->comments) ) }}
			</div>
			{{ $errors->has('comments') ? $errors->first('comments', '<p class="error">:message</p>') : '' }}
		</div>

		<a class="btn" href="/{{ Request::segment(1) }}">Cancel</a>
		
		<input type="submit" class="btn submit" value="Save">
	
	{{ Form::close() }}
	
@stop

@section('head')
	{{ HTML::style('assets/plugins/jquery-ui-1.10.3.custom/css/ui-darkness/jquery-ui-1.10.3.custom.min.css') }}
@stop

@section('scripts')
	{{ HTML::script('assets/plugins/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.js') }}
	{{ HTML::script('assets/js/bill-forms.js') }}
@stop