<?php

Use Carbon\Carbon;
use Lib\ReCaptcha\ReCaptcha;

class UserController extends BaseController {

	protected $Connection;
	protected $table;
	protected $hashKey;
	protected $expire;

	public function __construct()
	{
		$this->Connection = DB::connection();
		$this->table = Config::get('auth.confirmation.table');
		$this->hashKey = Config::get('app.key');
		$this->expire = Config::get('auth.confirmation.expire', 60);
	}

	/**
	 * Recaptcha verification.
	 * @param  string $user_input_recaptcha
	 * @param  string $user_ip
	 * @return object
	 */
	private function recaptcha($user_input_recaptcha, $user_ip)
	{
		$secret_captcha = $_ENV['SECRET_CAPTCHA'];
		$response_captcha = NULL;

		if($user_input_recaptcha)
		    $response_captcha = ReCaptcha::verifyResponse($user_ip, $user_input_recaptcha, $secret_captcha);

		return $response_captcha;
	}

	/**
	 * Generate new token.
	 * @param  string $email
	 * @return string
	 */
	private function generate_token($email)
	{
		$value = str_shuffle(sha1($email.spl_object_hash($this).microtime(true)));

		return hash_hmac('sha1', $value, $this->hashKey);
	}

	public function register()
	{
		$countries = Country::lists('name');

		return View::make('user.register')->with('countries', $countries);
	}

	public function post_register()
	{
		$rules = [
			'name'=>'required',
			'email'=>'required|email|unique:users',
			'password'=>'required|confirmed|min:6',
			'country'=>'not_in:0'
		];

		$input = Input::only('name', 'email', 'password', 'password_confirmation', 'country');
		$validator = Validator::make($input, $rules);

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$User = new User;
		$name = Input::get('name');
		$User->name = $name;
		$email = Input::get('email');
		$User->email = $email;
		$User->password = Hash::make(Input::get('password'));
		$User->country_id = Input::get('country') + 1; // because of DB id start 1 but array key start 0
		$confirmation_code = $this->generate_token($email);
		$User->confirmation_code = $confirmation_code;
		$User->save();

		$confirmation_view = Config::get('auth.confirmation.email');
		$email_data = ['confirmation_code'=>$confirmation_code];

		Mail::queue($confirmation_view, $email_data, function($message) use($name, $email) {
			$message->to($email, $name)->subject('k2movie - Account Activation');
		});
		
		return Redirect::route('home')->with('flash_notice', 'Please click the activation link inside the email sent to you');
	}

	public function activate($confirmation_code = NULL)
	{
		if (is_null($confirmation_code))
			App::abort(404);

		return View::make('user.activate')->with('confirmation_code', $confirmation_code);
	}

	public function put_activate()
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
		if($response_captcha === NULL || $response_captcha['success'] !== TRUE)
			return Redirect::back()->withInput()->withErrors(['credentials'=>'ReCaptcha failed']);

		$credentials = Input::only('email', 'password', 'confirmation_code');

		if(Auth::validate($credentials)) {
			$User = User::where('confirmation_code', '=', Input::get('confirmation_code'))
				->where('email', '=', Input::get('email'))
				->first();
				
			if(!$User)
				return Redirect::back()->withInput()->withErrors(['credentials'=>'Invalid activation code']);

			$User->confirmed = 1;
			$User->confirmation_code = NULL;
			$User->save();

			return Redirect::route('home')->with('flash_notice', 'User account activated successfully');
		} else {
			return Redirect::back()->withInput()->withErrors(['credentials'=>'Invalid credentials']);
		}
	}

	public function register_remail()
	{
		return View::make('user.register_remail');
	}

	public function put_register_remail()
	{
		$rules = ['email'=>'required|email|exists:users'];

		$input = Input::only('email');
		$validator = Validator::make($input, $rules);

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$User = User::where('email', '=', Input::get('email'))->first();

		if($User->confirmed === '1')
			return Redirect::back()->withInput()->withErrors(['credentials'=>'User already been activated']);

		$name = $User->name;
		$email = $User->email;
		$confirmation_code = $User->confirmation_code;

		$confirmation_view = Config::get('auth.confirmation.email');
		$email_data = ['confirmation_code'=>$confirmation_code];

		Mail::queue($confirmation_view, $email_data, function($message) use($name, $email) {
			$message->to($email, $name)->subject('k2movie - Account Activation');
		});
		
		return Redirect::route('home')->with('flash_notice', 'Account activation email resend successfully');
	}

	public function login()
	{
		return View::make('user.login');
	}

	public function put_login()
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

	public function put_login2()
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

		if(Input::has('recaptcha')) {
			$response_captcha = $this->recaptcha($_POST["g-recaptcha-response"], $_SERVER["REMOTE_ADDR"]);
			if($response_captcha === NULL || $response_captcha['success'] !== TRUE)
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
			$is_unconfirmed = TRUE;

			return Redirect::back()->withInput()->with(compact('email', 'is_unconfirmed'))->withErrors(['credentials'=>'User not yet confirmed, please click the activation link inside email']);
		} else {
			$User->login_trial_at = Carbon::now();
			$User->save();

			return Redirect::back()->withInput()->with(compact('email'))->withErrors(['credentials'=>'Login failed']);
		}
	}

	public function profile()
	{
		$User = Auth::user();
		$name = $User->name;
		$email = $User->email;
		$country = $User->country->name;

		if(Auth::user()->tsa_key)
			$exists_tsa_key = TRUE;
		else
			$exists_tsa_key = FALSE;

		return View::make('user.profile')->with(compact('name', 'email', 'country', 'exists_tsa_key'));
	}

	public function edit_profile()
	{
		$User = Auth::user();
		$name = $User->name;
		$user_country_id = $User->country_id - 1; // because of DB id start 1 but array key start 0
		$countries = Country::lists('name');
		$tsa_key_exists = isset($User->tsa_key);

		return View::make('user.edit')->with(compact('name', 'user_country_id', 'countries', 'tsa_key_exists'));
	}

	public function put_profile()
	{
		$rules = [
			'name'=>'required',
			'country'=>'not_in:0'
		];
		$input = Input::only('name', 'country');
		$validator = Validator::make($input, $rules);

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$User = Auth::user();
		$User->name = Input::get('name');
		$User->country_id = Input::get('country') + 1; // because of DB id start 1 but array key start 0

		if(Input::get('remove_tsa'))
			$User->tsa_key = NULL;

		$User->save();

		return Redirect::route('home')->with('flash_notice', "User's profile updated successfully");
	}

	public function edit_password()
	{
		return View::make('user.change_password');
	}

	public function put_password()
	{
		$rules = [
			'old_password'=>'required|min:6',
			'new_password'=>'required|confirmed|min:6'
		];

		$input = Input::only('old_password', 'new_password', 'new_password_confirmation');
		$validator = Validator::make($input, $rules);

		if($validator->fails())
			return Redirect::back()->withInput()->withErrors($validator);

		$User = Auth::user();
		$credentials = [
			'email'=>$User->email,
			'password'=>Input::get('old_password')
		];

		if(Auth::validate($credentials)) {
			$User->password = Hash::make(Input::get('new_password'));
			$User->save();
		} else {
			return Redirect::back()->withErrors(['credentials'=>'Incorrect Old Password']);
		}

		return Redirect::route('home')->with('flash_notice', 'Password changed successfully');
	}

	public function logout()
	{
		Auth::logout();

		return Redirect::route('home')->with('flash_notice', 'User logout successfully');
	}

}
