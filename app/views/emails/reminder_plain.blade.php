Hi {{ $user->forename != '' ? $user->forename : $user->username }},

You have some upcoming bills:

@foreach($user->bills as $bill)
------------------

{{ $bill->title }}

Due: {{ $bill->due_in == 0 ? 'today' : 'in ' . $bill->due_in . ' days' }}

Charge: £{{ $bill->amount }}

Recurrence: {{ Str::title($bill->recurrence) }}

Due: {{ date('D jS F', strtotime($bill->renewal_date)) }}

@endforeach

------------------

Regards

Billbot

http://billbot.aurer.co.uk