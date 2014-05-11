<?php

class BaseController extends Controller {

	/**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ($this->layout !== null)
		{
			$this->layout = View::make($this->layout);
		}
	}

}
