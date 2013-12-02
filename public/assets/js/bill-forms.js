$(function(){

	$('input[name=renews_on]').datepicker();

	$( "#recurrence" ).change(setDatepickerFormat);

	setDatepickerFormat();
});

function setDatepickerFormat(){
	var type = $( "#recurrence" ).val(), 
		formats = [];
	formats['monthly'] = 'dd';
	formats['yearly'] = 'dd MM';
	formats['weekly'] = 'DD';
	$( "input[name=renews_on]" ).datepicker( "option", "dateFormat", formats[type] );
}
