<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function bills()
	{
		return $this->hasMany('Bill');
	}

	public static function withBillsToday()
	{
		$all_users = DB::table('users')->get();
		$users_to_notify = array();

		foreach ($all_users as $key=>$user) {

			// Add an urgent bills array to the user
			$user->bills = array();

			// Find available bills for the user
			$all_user_bills = DB::table('bills')->whereUserId($user->id)->whereSendReminder(true)->get();
			
			// Sort bills by due date and add 'due_in'
			$bills = Bill::sort_bills_by_date($all_user_bills);
			
			// Loop over the users bills and find any urgent ones
			foreach ($bills as $bill) {
				if($bill->due_in == 0 || $bill->due_in - $bill->reminder < 1){
					array_push($user->bills, $bill);
				}
			}

			// Add user to array if they have urgent bills
			if( count($user->bills) > 0 ){
				array_push($users_to_notify, $user);
			}
		}

		return $users_to_notify;
	}
}