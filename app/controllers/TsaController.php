<?php

use Illuminate\Auth\Reminders\DatabaseReminderRepository;

require_once app_path()."/lib/ReCaptcha.php";
require_once app_path()."/lib/Google2FA.php";

class TsaController extends BaseController {

	private function recaptcha($user_input_recaptcha, $user_ip)
	{
		$secret_captcha = $_ENV['SECRET_CAPTCHA'];
		$response_captcha = NULL;
		$ReCaptcha = new ReCaptcha($secret_captcha);

		if($user_input_recaptcha)
		    $response_captcha = $ReCaptcha->verifyResponse($user_ip, $user_input_recaptcha);

		return $response_captcha;
	}

	private function generate_token($User)
	{
		$Connection = DB::connection();
		$table = Config::get('auth.tsa.table');
		$key = Config::get('app.key');
		$expire = Config::get('auth.tsa.expire', 60);

		$DatabaseReminderRepository = new DatabaseReminderRepository($Connection, $table, $key, $expire);

		return $DatabaseReminderRepository->createNewToken($User);
	}

	public function login_tsa()
	{
		if(!Session::has('email') || !Session::has('remember_me') || !Session::has('tsa_key'))
			return Redirect::route('user.login')->withErrors(['credentials'=>'Please login']);

		$email = Session::get('email');
		$remember_me = Session::get('remember_me');
		$tsa_key = Session::get('tsa_key');

		return View::make('tsa.login')->with(compact('email', 'remember_me', 'tsa_key'));
	}

	public function post_login_tsa()
	{
		$rules = ['verification_code'=>'required|digits:6'];
		$input = Input::only('verification_code');
		$validator = Validator::make($input, $rules);

		$email = Input::get('email');
		$password = Input::get('password');
		$remember_me = Input::get('remember_me');
		$tsa_key = Input::get('tsa_key');
		$verification_code = Input::get('verification_code');

		if($validator->fails())
			return Redirect::back()->withInput()->with(compact('email', 'remember_me', 'tsa_key'))->withErrors($validator);

		$tsa_key_decrypted = Crypt::decrypt($tsa_key);
		$result = Google2FA::verify_key($tsa_key_decrypted, $verification_code);

		if(!$result)
			return Redirect::back()->withInput()->with(compact('email', 'remember_me', 'tsa_key'))->withErrors(['credentials'=>'Invalid Verification Code']);

		$credentials = [
			'email'=>$email,
			'password'=>$password,
		];

		if(Auth::attempt($credentials, $remember_me))
			return Redirect::route('home')->with('flash_notice', 'User login successfully');
		else
			return Redirect::route('user.login')->withErrors(['credentials'=>'Login failed']);
	}

	public function remind_tsa()
	{
		return View::make('tsa.remind');
	}

	public function post_remind_tsa()
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

		$email = Input::get('email');

		if(Auth::validate($input)) {
			$User = User::where('email', '=', $email)->first();
			$name = $User->name;

			if(is_null($User->tsa_key))
				return Redirect::route('user.login')->withErrors(['credentials'=>'User do not have Two Step Authentication']);

			// generate tsa token
			$tsa_token = $this->generate_token($User);
			$TsaReminder = TsaReminder::create(['email'=>$email, 'tsa_token'=>$tsa_token]);

			$tsa_email_view = Config::get('auth.tsa.email');
			$email_data = ['tsa_token'=>$tsa_token];

			Mail::queue($tsa_email_view, $email_data, function($message) use($email, $name) {
			    $message->to($email, $name)->subject('k2movie - Remove Two Step Authentication');
			});

			return Redirect::route('home')->with('flash_notice', 'Please click the removal link inside the email sent to you');
		} else {
			return Redirect::back()->withInput()->withErrors(['credentials'=>'Invalid credentials']);
		}
	}

	public function remove_tsa($tsa_token = NULL)
	{
		if (is_null($tsa_token))
			App::abort(404);

		return View::make('tsa.remove')->with('tsa_token', $tsa_token);
	}

	public function post_remove_tsa()
	{
		$rules = [
			'email'=>'required|email|exists:users',
			'password'=>'required'
		];

		$input = Input::only('email', 'password');
		$validator = Validator::make($input, $rules);

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		if(Auth::validate($input)) {
			$TsaReminder = TsaReminder::where('tsa_token', '=', Input::get('tsa_token'))->where('email', '=', Input::get('email'))->delete();

			if(!$TsaReminder)
				return Redirect::back()->withInput()->withErrors(['credentials'=>'Invalid tsa_token']);

			$User = User::where('email', '=', Input::get('email'))->first();
			$User->tsa_key = NULL;
			$User->save();

			return Redirect::route('home')->with('flash_notice', 'Two Step Authentication remove successfully');
		} else {
			return Redirect::back()->withInput()->withErrors(['credentials'=>'Invalid credentials']);
		}
	}

	public function setup_tsa()
	{
		if(Session::has('tsa_key'))
			$tsa_key = Session::get('tsa_key');
		else
			$tsa_key = Google2FA::generate_secret_key(16);

		$qr_link = 'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/k2movie.k2studio.net%3Fsecret%3D'.$tsa_key;

		return View::make('tsa.setup')->with(compact('tsa_key', 'qr_link'));
	}

	public function post_setup_tsa()
	{
		$rules = ['verification_code'=>'required|digits:6'];
		$input = Input::only('verification_code');
		$validator = Validator::make($input, $rules);

		$tsa_key = Input::get('tsa_key');
		$verification_code = Input::get('verification_code');

		if($validator->fails()) {
			return Redirect::back()->withInput()->with('tsa_key', $tsa_key)->withErrors($validator);
		}

		$result = Google2FA::verify_key($tsa_key, $verification_code);
		if(!$result)
			return Redirect::back()->withInput()->with('tsa_key', $tsa_key)->withErrors(['credentials'=>'Invalid Verification Code']);

		Auth::user()->tsa_key = Crypt::encrypt($tsa_key);
		Auth::user()->save();

		return Redirect::route('home')->with('flash_notice', 'Two Step Authentication setup successfully');
	}

}
