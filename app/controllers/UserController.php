<?php

require_once app_path()."/lib/ReCaptcha.php";

Use Carbon\Carbon;

class UserController extends BaseController {

	/**
	 * Recaptcha verification
	 * @param  string $user_input_recaptcha
	 * @param  string $user_ip
	 * @return object
	 */
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
			$message->to($email, $name)->subject('k2movie - Account Activation');
		});
		
		return Redirect::route('home')->with('flash_notice', 'Please click the activation link inside the email sent to you');
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
		$rules = ['email'=>'required|email|exists:users'];

		$input = Input::only('email');
		$validator = Validator::make($input, $rules);

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$email = Input::get('email');
		
		return Redirect::route('user.login2')->with(compact('email'));
	}

	public function login2()
	{
		$email = Session::get('email');
		$login_trial_at = User::where('email', '=', $email)->first()->login_trial_at;

		return View::make('user.login2')->with(compact('email', 'login_trial_at'));
	}

	public function post_login2()
	{
		$rules = [
			'email'=>'required|email|exists:users',
			'password'=>'required'
		];

		$input = Input::only('email', 'password');
		$validator = Validator::make($input, $rules);
		$email = Input::get('email');

		if($validator->fails())
			return Redirect::back()->withInput()->with(compact('email'))->withErrors($validator);

		if(Input::has('g-recaptcha-response')) {
			$response_captcha = $this->recaptcha($_POST["g-recaptcha-response"], $_SERVER["REMOTE_ADDR"]);
			if($response_captcha === NULL || $response_captcha->success !== TRUE)
				return Redirect::back()->withInput()->with(compact('email'))->withErrors(['credentials'=>'ReCaptcha failed']);
		}

		$credentials = [
			'email'=>Input::get('email'),
			'password'=>Input::get('password'),
			'confirmed'=>1
		];

		$User = User::where('email', '=', Input::get('email'))->first();
		$confirmed = $User->confirmed;

		if(Auth::attempt($credentials, Input::get('remember_me'))) {
			$User->login_trial_at = NULL;
			$User->save();

			if(Auth::user()->tsa_key !== NULL) {
				$email = Input::get('email');
				$password = Input::get('password');
				$remember_me = Input::get('remember_me');
				Auth::logout();

				return Redirect::route('user.tsa.login')->with(compact('email', 'password', 'remember_me'));
			}
			return Redirect::route('home')->with('flash_notice', 'User login successfully');
		} else if($confirmed === '0') {
			return Redirect::back()->withInput()->with(compact('email'))->withErrors(['credentials'=>'User not yet confirmed, please click the activation link inside email']);
		} else {
			$User->login_trial_at = Carbon::now();
			$User->save();

			return Redirect::back()->withInput()->with(compact('email'))->withErrors(['credentials'=>'Login failed']);
		}
	}

	public function profile()
	{
		$name = Auth::user()->name;
		$email = Auth::user()->email;

		if(Auth::user()->tsa_key)
			$exists_tsa_key = TRUE;
		else
			$exists_tsa_key = FALSE;

		return View::make('user.profile')->with(compact('name', 'email', 'exists_tsa_key'));
	}

	public function edit_profile()
	{
		$User = Auth::user();
		$name = $User->name;
		$tsa_key_exists = isset($User->tsa_key);

		return View::make('user.edit')->with(compact('name', 'tsa_key_exists'));
	}

	public function put_profile()
	{
		$rules = ['name'=>'required'];
		$input = Input::only('name');
		$validator = Validator::make($input, $rules);
		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$User = Auth::user();
		$User->name = Input::get('name');

		if(Input::get('remove_tsa'))
			$User->tsa_key = NULL;

		$User->save();

		return Redirect::route('home')->with('flash_notice', "User's profile updated successfully");
	}

	public function logout()
	{
		Auth::logout();

		return Redirect::route('home')->with('flash_notice', 'User logout successfully');
	}

}
