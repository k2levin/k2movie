<?php

require_once app_path()."/lib/ReCaptcha.php";
require_once app_path()."/lib/Google2FA.php";

class UserController extends BaseController {

	private function recaptcha($user_input_recaptcha, $user_ip)
	{
		$secret_captcha = $_ENV['SECRET_CAPTCHA'];
		$response_captcha = NULL;
		$ReCaptcha = new ReCaptcha($secret_captcha);

		if($user_input_recaptcha)
		    $response_captcha = $ReCaptcha->verifyResponse($user_ip, $user_input_recaptcha);

		return $response_captcha;
	}

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

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$response_captcha = $this->recaptcha($_POST["g-recaptcha-response"], $_SERVER["REMOTE_ADDR"]);

		if($response_captcha === NULL || $response_captcha->success !== TRUE)
			return Redirect::back()->withInput()->withErrors(['credentials'=>'ReCaptcha failed']);

		$confirmation_code = str_random(30);
		$email_data = ['confirmation_code'=>$confirmation_code];

		$User = new User;
		$name = Input::get('name');
		$User->name = $name;
		$email = Input::get('email');
		$User->email = $email;
		$User->password = Hash::make(Input::get('password'));
		$User->confirmation_code = $confirmation_code;
		$User->save();

		Mail::queue('emails.auth.activate', $email_data, function($message) use($name, $email) {
			$message->to($email, $name)
					->subject('k2movie - Account Activation');
		});
		
		return Redirect::route('home')
			->with('flash_notice', 'Please click the activation link inside the email sent to you');
	}

	public function activate($confirmation_code)
	{
		$user = User::where('confirmation_code', '=', $confirmation_code)->first();

		if(!$user)
			return Redirect::route('user.login')->withErrors(['credentials'=>'Invalid activation code']);

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

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$response_captcha = $this->recaptcha($_POST["g-recaptcha-response"], $_SERVER["REMOTE_ADDR"]);

		if($response_captcha === NULL || $response_captcha->success !== TRUE)
			return Redirect::back()->withInput()->withErrors(['credentials'=>'ReCaptcha failed']);

		$credentials = [
			'email'=>Input::get('email'),
			'password'=>Input::get('password'),
			'confirmed'=>1
		];

		$remember_me = Input::get('remember_me');
		$confirmed = User::where('email', '=', Input::get('email'))->first()->confirmed;

		if(Auth::attempt($credentials, $remember_me)) {
			if(Auth::user()->google2fa_key !== NULL) {
				Session::put('email', Input::get('email'));
				Session::put('password', Input::get('password'));
				Session::put('remember_me', Input::get('remember_me'));
				Session::put('google2fa_key', Auth::user()->google2fa_key);
				Auth::logout();

				return Redirect::route('user.tsa.login');
			}
			return Redirect::route('home')->with('flash_notice', 'User login successfully');
		} else if($confirmed === '0') {
			return Redirect::back()->withInput()
				->withErrors(['credentials'=>'User not yet confirmed, please click the activation link inside email']);
		} else {
			return Redirect::back()->withInput()->withErrors(['credentials'=>'Login failed']);
		}
	}

	// login with 2 step authencation
	public function login_tsa()
	{
		if(!Session::has('email') || !Session::has('password') || !Session::has('remember_me') || !Session::has('google2fa_key'))
			return Redirect::route('user.login')->withErrors(['credentials'=>'Please login']);

		$google2fa_key = Session::get('google2fa_key');
		$qr_link = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/k2movie.k2studio.net%3Fsecret%3D'.$google2fa_key;
		$email = Session::get('email');
		$password = Session::get('password');
		$remember_me = Session::get('remember_me');

		return View::make('user.tsa.login')->with(compact('google2fa_key', 'email', 'password', 'remember_me'));
	}

	public function post_login_tsa()
	{
		$rules = ['verification_code'=>'required|digits:6'];

		$input = Input::only('verification_code');
		$validator = Validator::make($input, $rules);

		$google2fa_key = Crypt::decrypt(Input::get('google2fa_key'));
		$verification_code = Input::get('verification_code');

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$result = Google2FA::verify_key($google2fa_key, $verification_code);

		if(!$result)
			return Redirect::back()->withInput()->withErrors(['credentials'=>'Invalid Verification Code']);

		$email = Input::get('email');
		$password = Input::get('password');
		$credentials = [
			'email'=>$email,
			'password'=>$password,
			'confirmed'=>1
		];
		$remember_me = Input::get('remember_me');

		if(Auth::attempt($credentials, $remember_me))
			return Redirect::route('home')->with('flash_notice', 'User login successfully');
		else
			return Redirect::route('user.login')->withErrors(['credentials'=>'Login failed']);
	}

	public function profile()
	{
		$name = Auth::user()->name;
		$email = Auth::user()->email;

		if(Auth::user()->google2fa_key)
			$exists_google2fa_key = TRUE;
		else
			$exists_google2fa_key = FALSE;

		return View::make('user.profile')->with(compact('name', 'email', 'exists_google2fa_key'));
	}

	// setup 2 step authencation
	public function setup_tsa()
	{
		if(Session::has('google2fa_key'))
			$google2fa_key = Session::get('google2fa_key');
		else
			$google2fa_key = Google2FA::generate_secret_key(16);

		$qr_link = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/k2movie.k2studio.net%3Fsecret%3D'.$google2fa_key;

		return View::make('user.tsa.setup')->with(compact('google2fa_key', 'qr_link'));
	}

	public function post_setup_tsa()
	{
		$rules = ['verification_code'=>'required|digits:6'];

		$input = Input::only('verification_code');
		$validator = Validator::make($input, $rules);

		$google2fa_key = Input::get('google2fa_key');
		$verification_code = Input::get('verification_code');

		if($validator->fails()) {
			Session::flash('google2fa_key', $google2fa_key);

			return Redirect::back()->withInput()->withErrors($validator);
		}

		$result = Google2FA::verify_key($google2fa_key, $verification_code);

		if(!$result) {
			Session::flash('google2fa_key', $google2fa_key);

			return Redirect::back()->withInput()->withErrors(['credentials'=>'Invalid Verification Code']);
		}

		Auth::user()->google2fa_key = Crypt::encrypt($google2fa_key);
		Auth::user()->save();

		return Redirect::route('home')->with('flash_notice', 'Two Step Authentication setup successfully');
	}

	public function logout()
	{
		Auth::logout();

		return Redirect::route('home')->with('flash_notice', 'User logout successfully');
	}

}
