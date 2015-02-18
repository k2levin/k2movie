<?php

class UserController extends BaseController {

	public function register()
	{
		return View::make('user.register');
	}

	public function post_register()
	{
		$rules = [
			'name'=>'required',
			'email'=>'required|email|unique:users',
			'password'=>'required|confirmed|min:6'
		];

		$input = Input::only('name', 'email', 'password', 'password_confirmation');

		$validator = Validator::make($input, $rules);

		if($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$confirmation_code = str_random(30);
		$email_data = ['confirmation_code'=>$confirmation_code];

		$User = new User;
		$User->name = Input::get('name');
		$User->email = Input::get('email');
		$User->password = Hash::make(Input::get('password'));
		$User->confirmation_code = $confirmation_code;
		$User->save();

		Mail::queue('emails.auth.activate', $email_data, function($message) {
			$message->to(Input::get('email'), Input::get('username'))
					->subject('k2movie - Account Activation');
		});
		
		return Redirect::route('home')
			->with('flash_notice', 'Please click the activation link inside the email sent to you');
	}

	public function activate($confirmation_code)
	{
		$user = User::where('confirmation_code', '=', $confirmation_code)->first();

		if(!$user) {
			return Redirect::route('user.login')->withErrors(['credentials'=>'Invalid activation code']);
		}

		$user->confirmed = 1;
		$user->confirmation_code = NULL;
		$user->save();

		return Redirect::route('user.login')->with('flash_notice', 'User account activated successfully');
	}

	public function login()
	{
		return View::make('user.login');
	}

	public function post_login()
	{
		$rules = [
			'email'=>'required|email|exists:users',
			'password'=>'required'
		];

		$input = Input::only('email', 'password');

		$validator = Validator::make($input, $rules);

		if($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$credentials = [
			'email'=>Input::get('email'),
			'password'=>Input::get('password'),
			'confirmed'=>1
		];

		$remember_me = Input::get('remember_me');

		if(Auth::attempt($credentials, $remember_me)) {
			return Redirect::route('home')->with('flash_notice', 'User login successfully');
		} else {
			return Redirect::back()->withInput()->withErrors(['credentials'=>'Login failed']);
		}
	}

	public function profile()
	{
		$name = Auth::user()->name;
		$email = Auth::user()->email;

		return View::make('user.profile')->with(compact('name', 'email'));
	}

	public function logout()
	{
		Auth::logout();

		return Redirect::route('home')->with('flash_notice', 'User logout successfully');
	}

}
