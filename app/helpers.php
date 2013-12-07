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

/*
	Date a date and format and return it so it can be shown as an upcoming date

	e.g Weekly, 2 would result in Tuesday 26th (or whatever the date of the next tuesday is)
*/
function renewal_date_for_display($type, $date, $from_format = array()) {
	
	$to_format['weekly'] 	= 'l jS';
	$to_format['monthly'] 	= 'js F';
	$to_format['yearly'] 	= 'js F';

	return billbot_date_format($type, $date, $to_format, $from_format);
}

/*
	Date a date and format and return it so it can be shown in a form

	e.g Weekly, 2 would result in Tuesday
*/
function renewal_date_for_form($type, $date, $from_format = array()) {
	
	$to_format['weekly'] 	= 'l';
	$to_format['monthly'] 	= 'j';
	$to_format['yearly'] 	= 'j F';

	return billbot_date_format($type, $date, $to_format, $from_format);
}

/*
	Date a date and format and return it so it can be inserted into the DB

	e.g Weekly, tuesday would result in 2
*/
function renewal_date_for_insert($type, $date, $from_format = array()) {
	
	$to_format['weekly'] 	= 'N';
	$to_format['monthly'] 	= 'j';
	$to_format['yearly'] 	= 'z';

	return billbot_date_format($type, $date, $to_format, $from_format);
}

/*
	Sanitise and convert a date to output in the desired format
*/
function billbot_date_format($type, $date, array $to_format, $from_format = array()){
	
	$from_format_default['weekly'] 	= 'd-M-Y';
	$from_format_default['monthly'] = 'd';
	$from_format_default['yearly'] 	= 'j F';
	$from_format = array_replace($from_format_default, $from_format);

	$interval['weekly'] 	= 'P7D';
	$interval['monthly'] 	= 'P1M';
	$interval['yearly'] 	= 'P1Y';

	if($type === 'weekly'){
		$days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
		if( !is_numeric($date) ){
			if( !in_array(strtolower($date), $days)	){
				return false;
			}
			$date = idate('w', strtotime($date));
		}
		$date = date('d-M-Y', strtotime($days[strtolower($date)]));
	} elseif( $type === 'month;y' ) {
		$date = str_ireplace(range('a', 'z'), '', $date); // Remove any a-z characters from string e.g from '3rd' or '4th'
	}

	$datetime = DateTime::createFromFormat($from_format[$type], $date);

	if (!$datetime) {
		return $date;
	}

	if( $datetime->format('Y-m-d') < date('Y-m-d') ) {
		$datetime->add( new DateInterval($interval[$type]) );
	}
	return $datetime->format($to_format[$type]);
}

function fieldError($errors, $field)
{
	return $errors->has($field) ? $errors->first($field, '<p class="error">:message</p>') : '';
}

function strBool($bool){
	return $bool ? 'true' : 'false';
}