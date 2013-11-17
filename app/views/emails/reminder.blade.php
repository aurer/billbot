@extends('_templates.email')
@section('pagetitle') Just a little reminder @stop
@section('primary')
	<h2>Here are you upcoming bills</h2>
	<hr style="border:none; border-top: 1px solid #333">
	@foreach($user->bills as $bill)
		<h3>{{ $bill->title }}</h3>
		<h4>
			Due in {{ $bill->due_in }} days
			@if( $bill->send_reminder )
				<small> - Reminder
					@if($bill->reminder == 0)
						today</small>
					@else
						in {{ $bill->due_in - $bill->reminder }} {{ Str::plural('day', $bill->due_in - $bill->reminder) }}
					@endif
				</small>
			@endif
		</h4>
		<table class="bill-details">
			<tbody>
				<tr>
					<td title="Charge" class="cost"><b>&pound;{{ $bill->amount }}</b></td>
					<td title="Recurrence" class="recurrence">{{ Str::title($bill->recurrence) }}</td>
					<td title="Next due date" class="due">
						Due: {{ date('D jS F', strtotime($bill->renewal_date)) }}
					</td>
				</tr>
			</tbody>
		</table>
	@endforeach
@stop