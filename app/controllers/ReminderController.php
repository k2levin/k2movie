<?php

use Lib\ReCaptcha\ReCaptcha;

class ReminderController extends Controller {

	private function recaptcha($user_input_recaptcha, $user_ip)
	{
		$secret_captcha = $_ENV['SECRET_CAPTCHA'];
		$response_captcha = NULL;

		if($user_input_recaptcha)
		    $response_captcha = ReCaptcha::verifyResponse($user_ip, $user_input_recaptcha, $secret_captcha);

		return $response_captcha;
	}

	public function getRemind()
	{
		return View::make('password.remind');
	}

	public function postRemind()
	{
		$email = Input::get('email');
		$User = User::where('email', '=', $email)->first();

		if(!$User)
			return Redirect::back()->withInput()->withErrors(['flash_error'=>'Invalid email address']);

		$email_data = Input::only('email');

		// response variable not working with Queue
		Queue::push(function($job) use(&$response, $email_data)
		{
			$response = Password::remind($email_data, function($message)
			{
				$message->subject('k2movie - Password Reset');
			});

			$job->delete();
		});

		return Redirect::route('home')->with('flash_notice', 'Please click the reset link inside the email sent to you');
	}

	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);
	}

	public function putReset()
	{
		$response_captcha = $this->recaptcha($_POST["g-recaptcha-response"], $_SERVER["REMOTE_ADDR"]);
		if($response_captcha === NULL || $response_captcha['success'] !== TRUE)
			return Redirect::back()->withInput()->withErrors(['credentials'=>'ReCaptcha failed']);
		
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
