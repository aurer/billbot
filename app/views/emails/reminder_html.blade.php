@extends('_templates.email')
@section('pagetitle') Just a little reminder @stop
@section('primary')
	<h2>You have some upcoming bills</h2>
	<hr style="border:none; border-top: 1px solid #333">
	@foreach($user->urgent_bills as $bill)
		<h3>{{ $bill->title }}</h3>
		<h4>
			Due {{ $bill->due_in == 0 ? 'today' : 'in ' . $bill->due_in . ' days' }}
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