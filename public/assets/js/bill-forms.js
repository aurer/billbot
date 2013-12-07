$(function(){

	$( "input[name=renews_on]" ).datepicker({
		dateFormat: datepickerFormat()
	});

	$( "#recurrence" ).change(updateDatepickerFormat);
});

function updateDatepickerFormat(){
	$( "input[name=renews_on]" ).datepicker( "option", "dateFormat", datepickerFormat() );
}

function datepickerFormat(){
	var type = $( "#recurrence" ).val();
	var	formats = [];

	formats['monthly'] = 'dd';
	formats['yearly'] = 'dd MM';
	formats['weekly'] = 'DD';

	return formats[type];
}
