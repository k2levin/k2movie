<?php

class ReminderController extends Controller {

	public function getRemind()
	{
		return View::make('password.remind');
	}

	public function postRemind()
	{
		Queue::push(function()
		{
			$response = Password::remind(Input::only('email'), function($message)
			{
				$message->subject('Password Reminder');
			});
		});

		$response = Password::remind(Input::only('email'), function($message)
		{
			$message->subject('Password Reminder');
		});

		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->withInput()->withErrors(['flash_error'=>Lang::get($response)]);

			case Password::REMINDER_SENT:
				return Redirect::back()->withInput()->with('flash_notice', Lang::get($response));
		}
	}

	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);
	}

	public function postReset()
	{
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->withInput()->withErrors(['flash_error'=>Lang::get($response)]);

			case Password::PASSWORD_RESET:
				return Redirect::route('user.login')->with('flash_notice', 'User Password Reset Successfully');
		}
	}

}
