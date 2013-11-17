<?php

function datestr($datestring, $format='d M Y') {
	return date($format, strtotime($datestring));
}

function _bool($value) {
	return ($value) ? 'true' : 'false';
}

Form::macro('submit', function($label) {
    $str = '<input type="submit"';
    	if($label) $str .= 'value="' . $label.'"';
    $str .= '>';
    return $str;
});

Form::macro('dateselect', function($name, $value=null) {

	$selected['year'] = $value ? date('Y', strtotime($value)) : date('Y');
	$selected['month'] = $value ? date('m', strtotime($value)) : date('m');
	$selected['day'] = $value ? date('d', strtotime($value)) : date('d');

	$options['days'] = $options['months'] = $options['years'] = array();

	// Setup days of the month
	for($i=1; $i<32; $i++) {
		$options['days'][str_pad($i, 2, 0, STR_PAD_LEFT)] = str_pad($i, 2, 0, STR_PAD_LEFT);
	}

	// Setup months of the year
	for($i=1; $i<13; $i++) {
		$options['months'][str_pad($i, 2, 0, STR_PAD_LEFT)] = date("F", mktime(0, 0, 0, $i, 10));
	}

	// Setup sensible default years
	$start_year = (int)date('Y')-10;
	$end_year = (int)date('Y')+10;
	for( $i = $start_year; $i<$end_year; $i++ ) {
		$options['years'][$i] = $i;
	}

	$str = Form::select($name . "_day", $options['days'], $selected['day']);
	$str .= Form::select($name . "_month", $options['months'], $selected['month']);
	$str .= Form::select($name . "_year", $options['years'], $selected['year']);
	return $str;
});

function renewal_date_for_display($type, $date) {
	
	$to_format['weekly'] 	= 'l jS';
	$to_format['monthly'] 	= 'jS M';
	$to_format['yearly'] 	= 'jS M Y';

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
	return $datetime->format($to_format[$type]);
}

function renewal_date_for_input($type, $date) {
	
	$to_format['weekly'] 	= 'l';
	$to_format['monthly'] 	= 'jS';
	$to_format['yearly'] 	= 'jS M';

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
	return $datetime->format($to_format[$type]);
}