<?php

class UserController extends BaseController {

	public function register()
	{
		return View::make('user.register');
	}

	public function post_register()
	{
		$email = Input::get('email');
		$password = Input::get('password');
		$User = User::where('email', '=', $email)->first();

		if(!$User) {
			$User = new User;
			$User->email = $email;
			$User->password = Hash::make($password);
			$User->name = Input::get('name');
			$User->save();
		} else {
			return Redirect::back()
				->withInput()
				->with('flash_error', 'email already registered, please use another email');
		}
		
		return Redirect::route('home')
			->with('flash_notice', 'User registration successfully');
	}

	public function login()
	{
		return View::make('user.login');
	}

	public function post_login()
	{
		$email = Input::get('email');
		$password = Input::get('password');
		$remember_me = Input::get('remember_me');

		if(Auth::attempt(['email'=>$email, 'password'=>$password], $remember_me)) {
			return Redirect::route('home')
				->with('flash_notice', 'User login successfully');
		} else {
			return Redirect::back()
				->withInput()
				->with('flash_error', 'Invalid email or password');
		}
	}

	public function profile()
	{
		$name = Auth::user()->name;
		$email = Auth::user()->email;

		return View::make('user.profile')
			->with(compact('name', 'email'));
	}

	public function logout()
	{
		Auth::logout();

		return Redirect::route('home')
			->with('flash_notice', 'User logout successfully');
	}

}
