<?php

class PasswordsController extends Controller {
	
	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		// Show the page.
		return View::make('password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
		// Password Remind
		$response = Password::remind(Input::only('email'), function($message){
			$message->subject('Password Reset');
		});
		
		// Switch
		switch ($response)
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('status', Lang::get($response));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		// Token
		if ($token === null)
		{
			// 404
			App::abort(404);
		}
		
		// Show the page.
		return View::make('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
		// Credentials
		$credentials = Input::only(
			'email', 
			'password', 
			'password_confirmation', 
			'token'
		);

		// Password Reset
		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});

		// Switch reponse
		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::to('account/login')->with('success', 'Password Reset!');
		}
	}

}
