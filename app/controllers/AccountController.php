<?php

class AccountController extends AuthorizedController {
	
	/**
	 * Let's whitelist all the methods we want to allow guests to visit!
	 *
	 * @access protected
	 * @var array
	 */
	protected $whitelist = [
		'getLogin', 
		'postLogin',
		'getRegister', 
		'postRegister',
		'getActivate',
		'postCheck'
	];
	
	/**
	 * Access Page
	 *
	 * @access private
	 * @return View
	 */
	private function onlyAccessOwnPage($id) {
		return ($id == Auth::user()->id || Auth::user()->isAdministrator());
	}
	
	/**
	 * Main users page.
	 *
	 * @access public
	 * @return View
	 */
	public function getIndex()
	{	
		// Show the page.
		return View::make('account.index')->with('user', Auth::user());
	}
	
	/**
	 *
	 *
	 * @access public
	 * @return Redirect
	 */
	public function postIndex()
	{
		// Method POST
		if (Input::server('REQUEST_METHOD') == 'POST')
        {
			// Declare the rules for the form validation.
			$rules = [
				'name'  => 'Required',
				'email' => 'Required|Email|Unique:users,email,' . Auth::user()->email . ',email'
			];

			// If we are updating the password.
			if (Input::get('password'))
			{
				// Update the validation rules.
				$rules['password'] = 'Required|Confirmed';
				$rules['password_confirmation'] = 'Required';
			}
			
			// Get all the inputs.
			$inputs = Input::all();

			// Validate the inputs.
			$validator = Validator::make($inputs, $rules);

			// Check if the form validates with success.
			if ($validator->passes())
			{
				// Auth ID
				$userId = Auth::user()->id;
				
				// Create the user.
				$user = User::find($userId);
				$user->name  = Input::get('name');
				$user->email = Input::get('email');
				
				// Update password
				if (Input::get('password') !== '')
				{
					$user->password = Hash::make(Input::get('password'));
				}

				$user->save();

				// Redirect to the register page.
				return Redirect::to('account')->with('success', 'Account updated with success!');
			}

			// Something went wrong.
			return Redirect::to('account')->withErrors($validator)->withInput($inputs);
		}
	}

	/**
	 * Used to Check Username
	 *
	 * @access public
	 * @return void
	 */
	public function postCheck() 
	{	
		// Request Ajax
		if (Request::ajax())
		{
			// Get all the inputs.
			$value = Input::get('value');
			
			// Validate
			if (empty($value)) {
				$return = ['ajaxData' => false];
			} else {
				// Check
				$userCheck = null;
				
				// Return
				$userCheck = User::where('email', '=', $value)->first();
				
				// Check
				if (empty($userCheck)) {
					$return = ['value' => true];
				} else {
					// Auth
					if (Auth::check())
					{
						// Auth Id
						$userId = Auth::user()->id;
						
						// Check
						if ($userCheck->id == $userId)
						{
							$return = ['value' => true];
						} else {
							$return = ['value' => false];
						}
					} else {
						$return = ['value' => false];
					}
				}
				
				// Clear
				unset($userCheck);
			}
		} else {
			$return = ['ajaxError' => false];
		}
		
		// Return Json
		return Response::json($return);
	}
	
	/**
	 * Login form page.
	 *
	 * @access public
	 * @return View
	 */
	public function getLogin()
	{
		// Are we logged in?
		if (Auth::check())
		{
			// Redirect Account
			return Redirect::to('account');
		}
		
		// Log the user out.
		Auth::logout();

		// Show the page.
		return View::make('account.login');
	}

	/**
	 * Login form processing.
	 *
	 * @access public
	 * @return Redirect
	 */
	public function postLogin()
	{
		// Method POST
		if (Input::server('REQUEST_METHOD') == 'POST')
        {
			// Declare the rules for the form validation.
			$rules = [
				'email' => 'Required|email',
				'password' => 'Required'
			];

			// Get all the inputs.
			$email    = Input::get('email');
			$password = Input::get('password');
			
			// Validate the inputs.
			$validator = Validator::make(Input::all(), $rules);

			// Check if the form validates with success.
			if ($validator->passes())
			{
				// Try to log the user in. "remember me" is True
				if (Auth::attempt(['email' => $email, 'password' => $password], true))
				{
					// Verification login.
					$user = User::where('id', '=', Auth::user()->id)->first();
					
					// Active ?
					if($user->is_active == 0)
					{
						// Log the user out.
						Auth::logout();
						
						// return error
						return Redirect::to('account/login')->with('error', 'Por favor revise su bandeja de correo electronico para activar su uenta.');
					} else {
						// Last login
						$user->last_login = date('Y-m-d H:i:s');
						$user->save();
					}
					
					// Redirect to the users page.
					return Redirect::to('account')->with('success', 'You have logged in successfully');
				} else {
					// Redirect to the login page.
					return Redirect::to('account/login')->with('error', 'Email/password invalid.');
				}
			}

			// Something went wrong.
			return Redirect::to('account/login')->withErrors($validator);
		}
	}
	
	/**
	 * User account creation form page.
	 *
	 * @access public
	 * @return View
	 */
	public function getRegister()
	{
		// Are we logged in?
		if (Auth::check())
		{
			// Redirect Account
			return Redirect::to('account');
		}
		
		// Show the page register.
		return View::make('account.register');
	}

	/**
	 * User account creation form processing.
	 *
	 * @access public
	 * @return Redirect
	 */
	public function postRegister()
	{
		// Method POST
		if (Input::server('REQUEST_METHOD') == 'POST')
        {
			// Declare the rules for the form validation.
			$rules = [
				'name'     => 'Required',
				'email'    => 'Required|Email|Unique:users',
				'password' => 'Required|Confirmed|min:6',
				'password_confirmation' => 'Required|min:6'
			];
			
			// Get all the inputs.
			$inputs = Input::all();

			// Validate the inputs.
			$validator = Validator::make($inputs, $rules);
			
			// Check if the form validates with success.
			if ($validator->passes())
			{
				//User IP
				$ip_address = 0;
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
					$ip_address = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$ip_address = $_SERVER['REMOTE_ADDR'];
				}
				
				// Code
				$code = str_random(8);
				
				// Create the user.
				$user = new User;
				$user->role_id        = 4;
				$user->code           = $code;
				$user->name           = Input::get('name');
				$user->email          = Input::get('email');
				$user->password       = Hash::make(Input::get('password'));
				$user->is_active      = 0;
				$user->email_verified = 1;
				$user->ip_address     = $ip_address;
				
				// Save
				$user->save();
				
				// Email Activeta
				$email = Mail::send('emails.activate', ['name' => 'HelloSociets', 'link' => '/account/activate/' . $code], function($message) use ($user) {
					$message->to($user->email, $user->name)->subject('Registro : Activar de cuenta');
				});
				
				// Redirect to the register page.
				return Redirect::to('account/login')->with('success', 'Account created with success!');
			}

			// Something went wrong.
			return Redirect::back()->withErrors($validator)->withInput($inputs);
		}
	}
	
	/**
	 * Account Active page.
	 *
	 * @access public
	 * @return Redirect
	 */
	public function getActivate($code) 
	{
		// Verification code
		$mUser = User::where('code', '=', $code)->where('is_active', '=', 0)->first();
		
		// Count
		if(!empty($mUser)) 
		{
			// Active
			$mUser->is_active = 1;
			
			// Save
			if($mUser->save()) 
			{
				// Success Active
				return Redirect::to('account/login')->with('success', 'active-account');
			}
			
			// Error Active
			return Redirect::to('account/login')->with('error', 'unactive-account');
		}
		
		// Error Active
		return Redirect::to('account/login')->with('error', 'unactive-account');
	}
	
	/**
	 * Logout page.
	 *
	 * @access public
	 * @return Redirect
	 */
	public function getLogout()
	{
		// Log the user out.
		Auth::logout();

		// Redirect to the users page.
		return Redirect::to('account/login')->with('success', 'Logged out with success!');
	}
	
}
