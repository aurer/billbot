@extends('_templates.default')

@section('pagetitle') Your Bills <a class="icon add" href="/bills/new"><i class="icon-">&#xf055;</i> New</a> @stop

@section('primary')
	
	<ul class="bills reset">
		@foreach($bills as $item)
			<li class="reminder-{{ $item->send_bills ? 'true' : 'false' }}">
				<div class="title">
					<h3>{{ $item->title }} </h3>
					<span class="actions">
						<a title="Edit this bill" href="/bills/edit/{{ $item->name }}"><i class="icon-">&#xf040;</i> Edit</a>
						<a title="Remove this bill" href="/bills/delete/{{ $item->id }}"><i class="icon-">&#xf057;</i> Remove</a>
					</span>
				</div>
				<h4>
					Due in {{ $item->due_in }} days
					@if( $item->send_reminder )
						<small> - Reminder
							@if($item->reminder == 0 && $item->due_in < 1)
								today</small>
							@else
								in {{ $item->due_in - $item->reminder }} {{ Str::plural('day', $item->due_in - $item->reminder) }}
							@endif
						</small>
					@endif
				</h4>
				<table class="bill-details">
					<tbody>
						<tr>
							<td title="Charge" class="cost"><b>&pound;{{ $item->amount }}</b></td>
							<td title="Recurrence" class="recurrence">{{ Str::title($item->recurrence) }}</td>
							<td title="Next due date" class="due">
								Due: {{ date('D jS F', strtotime($item->renewal_date)) }}
							</td>
						</tr>
					</tbody>
				</table>
			</li>
		@endforeach
		@if( !$bills )
			<p>It looks like you havent set up any bills yet, you can start by clicking '+ new' above.</p>
		@endif
	</ul>

	<hr>

	<h2>Totals</h2>
	<table class="layout totals">
		<tr>
			<th class="weekly_total">Weekly's</th>
			<th class="monthly_total">Monthly's</th>
			<th class="yearly_total">Yearly's</th>
		</tr>
		<tr>
			<td class="weekly_total"><i>&pound;</i>{{ $totals['weekly'] }}</td>
			<td class="monthly_total"><i>&pound;</i>{{ $totals['monthly'] }}</td>
			<td class="yearly_total"><i>&pound;</i>{{ $totals['yearly'] }}</td>
		</tr>
		<tr>
			<td class="total_per_month" colspan="2"><i>&pound;</i>{{ $totals['per_month'] }} / <i>&pound;</i>{{ $totals['per_month_plus'] }} <small>per month / including yearly's</small></td>
			<td class="total_per_year"><i>&pound;</i>{{ $totals['per_year'] }} <small>per year</small></td>
		</tr>
	</table>

@stop