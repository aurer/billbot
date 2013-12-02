<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NotifyCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:notify';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Notifies users of upcoming bills.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$users = User::withBillsToday();
		$this->info( 'Found ' . count($users) . ' users with upcoming bills.' );

		foreach ($users as $user) {
			$this->info('Sending email to ' . $user->email . ' who has ' . count($user->bills) . ' upcoming bills.');
			Mail::send(array('emails.reminder_html', 'emails.reminder_plain'), array('user' => $user), function($message) use ($user) {
				$message->to($user->email);
				$message->from('reminders@billbot.aurer.co.uk', 'Billbot');
			});
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('test', null, InputOption::VALUE_NONE, null, null),
		);
	}

}