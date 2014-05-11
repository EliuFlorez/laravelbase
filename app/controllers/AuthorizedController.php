<?php

class AuthorizedController extends BaseController {
	
	/**
	* White Lists
	*/
	protected $whitelist = [];

	/**
	 * Initializer.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Check if the user is logged in.
		$this->beforeFilter('auth', ['except' => $this->whitelist]);
	}
	
}
