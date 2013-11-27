$(function(){
	set_renew_date_format();
	$('#recurrence').on('change', function(){
		set_renew_date_format();
	});
});

function set_renew_date_format(){
	var input = $('#renews_on'),
		select = $('#recurrence'),
		format = select.val(),
		placeholder = [];

	placeholder['monthly']	= 'e.g. 10th';
	placeholder['yearly']	= 'e.g. 10th April';
	placeholder['weekly']	= 'e.g. Monday';
	input.attr('placeholder', placeholder[format]);
}