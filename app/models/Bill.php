<?php

class Bill extends Eloquent {

	public function user()
	{
		return $this->belongsTo('User');
	}
	/**
	 * Convert a renewal time supplied as either:
	 *
	 * 1. Day of the week
	 * 2. Day of the month
	 * 3. Day and month of the year
	 *
	 * Return a ISO standard date version of the next renewal date
	 *
	 */
	public static function renewal_date_to_date($type, $date)
	{
		$from_format['weekly'] 	= 'd-M-Y';
		$from_format['monthly'] = 'd';
		$from_format['yearly'] 	= 'z';

		$interval['weekly'] 	= 'P7D';
		$interval['monthly'] 	= 'P1M';
		$interval['yearly'] 	= 'P1Y';

		if($type==='weekly'){
			$day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
			$date = date('d-M-Y', strtotime($day[$date]));
		}

		$datetime = DateTime::createFromFormat($from_format[$type], $date);

		if( $datetime->format('Y-m-d') < date('Y-m-d') ) {
			$datetime->add( new DateInterval($interval[$type]) );
		}
		return $datetime->format('Y-m-d');
	}

	/**
	 * Sort an array of bill objects by their renewal date and add that date to the object	 *
	 *
	 */
	public static function sort_bills_by_date($bills)
	{
		uasort($bills, function($a, $b){
			$a_date = Bill::renewal_date_to_date($a->recurrence, $a->renews_on);
			$b_date = Bill::renewal_date_to_date($b->recurrence, $b->renews_on);
			
			// Add in renewal dates
			$a->renewal_date = $a_date;
			$b->renewal_date = $b_date;

			if ($a_date == $b_date) {
		        return 0;
		    }
		    return ($a_date < $b_date) ? -1 : 1;
		});

		// Add in the due_in date
		foreach ($bills as $bill) {
			$date2 = new DateTime($bill->renewal_date);
			$date1 = new DateTime(date("Y-m-d"));
			$interval = $date1->diff($date2);
			$bill->due_in = $interval->format('%a');
		}

		return $bills;
	}
}