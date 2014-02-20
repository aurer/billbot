<?php

class UserController extends BaseController
{
	public $restful = true;

	// Users profile
	public function get_index()
	{
		$data = Auth::user();
		return View::make('user.profile')->with( array('data' => $data) );
	}

	public function post_index()
	{
		$input = Input::all();
		$rules = array(
		    'username'  => 'required',
		    'email'  	=> 'required|email|unique:users,email,' . Auth::user()->id,
		);
		if( Input::get('password') || Input::get('password_confirm') ){
			$rules['password'] 			= 'required';
		    $rules['password_confirm']  = 'required|same:password';
		}
		
		$validation = Validator::make($input, $rules);
		if( $validation->fails() ){
			Input::flash();
			return Redirect::to( Request::path() )->with_errors($validation);
		}

		$user = Auth::user();
		$user->forename = Input::get('forename');
		$user->surname  = Input::get('surname');
		$user->username = Input::get('username');
		$user->email 	= Input::get('email');
		if( Input::get('password') || Input::get('password_confirm') ){
			$user->password = Hash::make(Input::get('password'));
		}
		$user->save();
		return Redirect::to( Request::path() )->with('success', 'Your details have been updated');
	}

	// Join form
	public function get_join()
	{
		return View::make('user.new');
	}

	// Thanks for joining
	public function get_thanks()
	{
		return View::make('user.thanks');
	}

	// Confirm registration via key
	public function get_confirm()
	{
		$user = User::whereActive(false)->whereHash(Input::get('hash'))->first();
		
		if($user){
			$user->hash = '';
			$user->active = true;
			$user->save();
			Auth::loginUsingId($user->id);
			return Redirect::to('/');
		}
		return Redirect::to('user/thanks')->with('error', 'The activation key you provided was not recognised or has expired.');
	}

	// Add new user
	public function post_join()
	{
		$input = Input::all();
		$rules = array(
		    'username'  		=> 'required',
		    'email'  			=> 'required|email|unique:users',
		    'password'  		=> 'required',
		    'password_confirm' 	=> 'required|same:password',
		);
		
		$validation = Validator::make($input, $rules);
		if( $validation->fails() ){
			Input::flash();
			return Redirect::to( Request::path() )->withErrors($validation);
		}
		
		$hash = Str::random(32);
		$user = new User;
		$user->forename = '';
		$user->surname  = '';
		$user->username = Input::get('username');
		$user->email 	= Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->active 	= false;
		$user->hash 	= $hash;
		$user->save();
		
		if( static::send_welcome_email($user) ){
			return Redirect::to( Request::segment(1) . '/thanks' );
		}

		return Redirect::to( Request::segment(1) );
	}

	public function get_reset()
	{
		return View::make('user.reset');
	}

	public function get_reset_sent()
	{
		return View::make('user.reset-sent');
	}

	public function get_reset_complete()
	{
		return View::make('user.reset-complete');
	}

	public function post_reset()
	{
		$input = Input::all();
		$rules = array(
			'email' => 'required|email|exists:users'
		);

		$validation = Validator::make($input, $rules);
		if( $validation->fails() ){
			Input::flash();
			return Redirect::to( Request::path() )->with_errors($validation);
		}

		$hash = Str::random(32);
		$user = User::whereEmail( Input::get('email') )->first();
		
		if(!$user){
			return Redirect::to( Request::path() )->with('error', "Sorry we couldn't find that email address in our records.");
		}

		$user->hash = $hash;
		$user->save();

		if( static::send_reset_email($user) ){
			return Redirect::to( Request::segment(1) . '/reset-sent' );
		}

		return Redirect::to( Request::segment(1) );		
	}

	// Confirm registration via key
	public function get_resetConfirm()
	{
		$data['user'] = User::whereHash(Input::get('hash'))->first();
		return View::make('user.reset-confirm')->with($data);
	}

	public function post_resetConfirm(){

		$input = Input::all();
		$rules = array(
			'password' => 'required',
			'password_confirm' => 'required|same:password',
		);
		$validation = Validator::make($input, $rules);
		if( $validation->fails() ){
			Input::flash();
			return Redirect::to( Request::path() . '?hash=' . Input::get('hash') )->withErrors($validation);
		}
		
		$user = User::whereHash(Input::get('hash'))->first();
		if($user){
			$user->hash = '';
			$user->active = true;
			$user->password = Hash::make( Input::get('password') );
			$user->save();
			Auth::loginUsingId($user->id);
			return Redirect::to('user/reset-complete');
		}
		return Redirect::to( Request::path() )->with('error', "Sorry but your reset token is invalid or has expired, please try again.");
	}

	public function get_remove()
	{
		return View::make('user.remove-confirm');
	}

	public function post_remove()
	{
		$user = Auth::user();
		$bills = Bill::whereUserId($user->id);
		$user->delete();
		$bills->delete();
		Auth::logout();
		return Redirect::to( '/' );
	}


	// Send a welcome email when joining
	private function send_welcome_email($user)
	{	
		$data = array('user' => $user);		
		return Mail::send('emails.user_welcome', $data, function($message) use ($user){
			$message->from('billbot@bills.aurer.co.uk', 'Billbot');
			$message->to($user->email);
			$message->subject('Welcome to Billbot');
		});
	}

	// Send a ressewt password email to user
	private function send_reset_email($user)
	{
		$data = array('user' => $user);
		return Mail::send('emails.user_reset', $data, function($message) use ($user){
			$message->from('billbot@bills.aurer.co.uk', 'Billbot');
			$message->to($user->email);
			$message->subject('You requested a password reset');
		});
	}
}