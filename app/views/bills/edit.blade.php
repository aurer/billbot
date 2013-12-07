@extends('_templates.default')

@section('pagetitle') Edit :: {{ $bill->title }} @stop

@section('primary')

	{{ Form::open() }}

		<div class="field required error-{{ strBool($errors->has('title')) }}">
			{{ Form::label('title', 'Title') }}
			<div class="input">
				{{ Form::text('title', Input::old('title', $bill->title)  ) }}
				{{ fieldError($errors, 'title') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('amount')) }}">
			{{ Form::label('amount', 'Amount') }}
			<div class="input">
				{{ Form::text('amount', Input::old('amount', $bill->amount) ) }}
				{{ fieldError($errors, 'amount') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('recurrence')) }}">
			{{ Form::label('recurrence', 'Recurrence') }}
			<div class="input">
				{{ Form::select('recurrence', array('monthly'=>'Monthly', 'yearly'=>'Yearly', 'weekly'=>'Weekly') , Input::old('recurrence', $bill->recurrence) ) }}
				{{ fieldError($errors, 'recurrence') }}
			</div>
		</div>

		<div class="field required error-{{ strBool($errors->has('renews_on')) }}">
			{{ Form::label('renews_on', 'Renews on') }}
			<div class="input">
				{{ Form::text('renews_on', renewal_date_for_form(Input::old('recurrence', $bill->recurrence), Input::old('renews_on', $bill->renews_on), array('yearly'=>'z')) ) }}
				{{ fieldError($errors, 'renews_on') }}
			</div>
		</div>

		<div class="field checkbox error-{{ strBool($errors->has('send_reminder')) }}">
			{{ Form::label('send_reminder', 'Send reminder?') }}
			<div class="input">
				{{ Form::checkbox('send_reminder', 'true', $bill->send_reminder ? true : false )}}
				{{ fieldError($errors, 'send_reminder') }}
			</div>
		</div>

		<div class="field checkbox error-{{ strBool($errors->has('include_in_totals')) }}">
			{{ Form::label('include_in_totals', 'Include in totals?') }}
			<div class="input">
				{{ Form::checkbox('include_in_totals', 'true', $bill->include_in_totals ? true : false )}}
				{{ fieldError($errors, 'include_in_totals') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('reminder')) }}">
			{{ Form::label('reminder', 'Remind me this many days before') }}
			<div class="input">
				{{ Form::input('number', 'reminder', Input::old('reminder', $bill->reminder) )}}
				{{ fieldError($errors, 'reminder') }}
			</div>
		</div>

		<div class="field error-{{ strBool($errors->has('comments')) }}">
			{{ Form::label('comments', 'Comments') }}
			<div class="input">
				{{ Form::textarea('comments', Input::old('comments', $bill->comments) ) }}
				{{ fieldError($errors, 'comments') }}
			</div>
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