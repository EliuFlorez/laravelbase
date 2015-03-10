<?php

// Use - Security Input
use GrahamCampbell\Binput\Facades\Binput;

class AuthController extends AuthorizedController {
	
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
		'postRegister'
	];
	
	/**
	 * Main users page.
	 *
	 * @access public
	 * @return View
	 */
	public function getIndex()
	{	
		// Show the page.
		return View::make('auth.index')->with('auth', Auth::user());
	}
	
	/**
	 *
	 *
	 * @access public
	 * @return Redirect
	 */
	public function postIndex()
	{
		// Declare the rules for the form validation.
		$rules = [
			'name'  => 'Required',
			'email' => 'Required|Email|Unique:users,email,' . Auth::user()->email . ',email'
		];

		// If we are updating the password.
		if (Binput::get('password'))
		{
			// Update the validation rules.
			$rules['password'] = 'Required|Confirmed';
			$rules['password_confirmation'] = 'Required';
		}
		
		// Get all the inputs.
		$inputs = Binput::all();

		// Validate the inputs.
		$validator = Validator::make($inputs, $rules);

		// Check if the form validates with success.
		if ($validator->passes())
		{
			// Auth ID
			$userId = Auth::user()->id;
			
			// Create the user.
			$user = User::find($userId);
			$user->name  = Binput::get('name');
			$user->email = Binput::get('email');
			
			// Update password
			if (Binput::get('password') !== '')
			{
				$user->password = Hash::make(Binput::get('password'));
			}

			// Save
			$user->save();

			// Redirect to the register page.
			return Redirect::to('auth')->with('success', 'Updated with success!');
		}

		// Something went wrong.
		return Redirect::to('auth')->withErrors($validator)->withInput($inputs);
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
			return Redirect::to('auth');
		}
		
		// Log the user out.
		Auth::logout();

		// Show the page.
		return View::make('auth.login');
	}

	/**
	 * Login form processing.
	 *
	 * @access public
	 * @return Redirect
	 */
	public function postLogin()
	{
		// Declare the rules for the form validation.
		$rules = [
			'email' => 'Required|email',
			'password' => 'Required'
		];
		
		// Validate the inputs.
		$validator = Validator::make(Binput::all(), $rules);

		// Check if the form validates with success.
		if ($validator->passes())
		{
			// Get all the inputs.
			$email    = Binput::get('email');
			$password = Binput::get('password');
			
			// Try to log the user in. "remember me" is True
			if (Auth::attempt(['email' => $email, 'password' => $password], true))
			{
				// Redirect to the users page.
				return Redirect::to('auth')->with('success', 'You have logged in successfully');
			} else {
				// Redirect to the login page.
				return Redirect::to('auth/login')->with('error', 'Email / password invalid.');
			}
		}

		// Something went wrong.
		return Redirect::to('auth/login')->withErrors($validator);
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
			return Redirect::to('auth');
		}
		
		// Show the page register.
		return View::make('auth.register');
	}

	/**
	 * User account creation form processing.
	 *
	 * @access public
	 * @return Redirect
	 */
	public function postRegister()
	{
		// Declare the rules for the form validation.
		$rules = [
			'name'     => 'Required',
			'email'    => 'Required|Email|Unique:users',
			'password' => 'Required|Confirmed|min:6',
			'password_confirmation' => 'Required|min:6'
		];
		
		// Get all the inputs.
		$inputs = Binput::all();

		// Validate the inputs.
		$validator = Validator::make($inputs, $rules);
		
		// Check if the form validates with success.
		if ($validator->passes())
		{
			// Create the user.
			$user = new User;
			$user->name     = Binput::get('name');
			$user->email    = Binput::get('email');
			$user->password = Hash::make(Binput::get('password'));
			
			// Save
			$user->save();
			
			// Email
			$email = Mail::queue('emails.welcome', ['name' => 'Welcome'], function($message) use ($user) {
				$message->to($user->email, $user->name)->subject('Hi Welcome');
			});
			
			// Redirect to the register page.
			return Redirect::to('auth/login')->with('success', 'Account created with success!');
		}

		// Something went wrong.
		return Redirect::back()->withErrors($validator)->withInput($inputs);
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
		return Redirect::to('auth/login')->with('success', 'Logged out with success!');
	}
	
}
