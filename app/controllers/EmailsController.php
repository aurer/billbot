<?php

class EmailsController extends BaseController
{
	public $restful = true;

	public function get_index()
	{
		$users_with_bills = User::withBillsToday();
		if( isset($users_with_bills[0]) ){
			return View::make('emails.reminder_html', array('user' => $users_with_bills[0]) );
		} else {
			return "There are no users with bills due today.";
		}
	}
}