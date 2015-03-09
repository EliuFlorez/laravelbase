<?php

// Use - Security Input
use GrahamCampbell\Binput\Facades\Binput;

class AccountsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Auth
		$userId = Auth::user()->id;
		
		// Search
		$query  = '';
		$sSort  = Binput::get('sort');
		$sOrder = Binput::get('order');
		$aLinks = array();
		
		if ( ! empty($sSort) && ! empty($sOrder))
		{
			$aLinks['sort']  = $sSort;
			$aLinks['order'] = $sOrder;
		}
		
		// Table Sort
		$allowed = array('id', 'first_name', 'last_name', 'phone');
		$sort    = in_array($sSort, $allowed) ? $sSort : 'id';
		
		// header links setup.
		$params = Request::except(['sort', 'order']);
		$order  = ($sOrder == 'asc') ? 'desc' : 'asc';

		$i = 0 ;
		$attributes = array();
		foreach ($allowed as $allow) 
		{
			$attributes[$i] = array_merge(['sort' => $allowed[$i], 'order' => $order], $params);
			$i++;
		}
		
		// get all the Account
		if ($query = Binput::get('q'))
		{
			$accounts = Account::where('user_id', $userId)
				->where('first_name', 'LIKE', '%'. $query .'%')
				->orderBy($sort, $order)
				->paginate(5);
		} 
		else 
		{
			$accounts = Account::where('user_id', $userId)
				->orderBy($sort, $order)
				->paginate(5);
		}
		
		// load the view and pass the item
		return View::make('accounts.index', compact('accounts', 'attributes', 'aLinks'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// load the create form (app/views/accounts/create.blade.php)
		return View::make('accounts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Auth
		$userId = Auth::user()->id;
		
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = [
			'first_name' => 'Required',
			'last_name'  => 'Required',
			'phone'      => 'Required|Numeric',
			'birth'      => 'Required|date_format:Y-m-d'
		];
		
		// Get all the inputs.
		$inputs = Binput::all();
		
		// Validator
		$validator = Validator::make($inputs, $rules);
		
		// process
		if ($validator->fails()) 
		{
			// Return Error
			return Redirect::to('accounts/create')->withErrors($validator)->withInput($inputs);
		} 
		else 
		{
			// store
			$account = new Account;
			$account->user_id    = $userId;
			$account->first_name = Binput::get('first_name');
			$account->last_name  = Binput::get('last_name');
			$account->phone      = Binput::get('phone');
			$account->birth      = Binput::get('birth');
			$account->save();

			// Redirect alert
			return Redirect::to('accounts')->with('success', 'Create Success!');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function show($id)
	{
		// Auth
		$userId = Auth::user()->id;
		
		// get the account
		$account = Account::where('id', $id)
			->where('user_id', $userId)
			->first();
		
		// Validator
		if ( ! empty($account)) 
		{
			// show the view and pass the item to it
			return View::make('accounts.show')->with('account', $account);
		} 
		else 
		{
			// Redirect to the account page.
			return Redirect::to('accounts')->with('error', 'Error register exist.');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Auth
		$userId = Auth::user()->id;
		
		// get the account
		$account = Account::where('id', $id)
			->where('user_id', $userId)
			->first();
		
		// Validator
		if ( ! empty($account))
		{
			// show the edit form and pass the account
			return View::make('accounts.edit')->with('account', $account);
		} 
		else 
		{
			// Redirect to the account page.
			return Redirect::to('accounts')->with('error', 'Error register exist.');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function update($id)
	{
		// Auth
		$userId = Auth::user()->id;
		
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = [
			'first_name' => 'Required',
			'last_name'  => 'Required',
			'phone'      => 'Required|Numeric',
			'birth'      => 'Required|date_format:Y-m-d'
		];
		
		// Get all the inputs.
		$inputs = Binput::all();
		
		// Validator
		$validator = Validator::make($inputs, $rules);
		
		// process
		if ($validator->fails()) 
		{
			// Return Error
			return Redirect::to('accounts/' . $id . '/edit')->withErrors($validator)->withInput($inputs);
		} 
		else 
		{
			// Find
			$account = Account::where('id', $id)
				->where('user_id', $userId)
				->first();
			
			// Update
			$account->first_name = Binput::get('first_name');
			$account->last_name  = Binput::get('last_name');
			$account->phone      = Binput::get('phone');
			$account->birth      = Binput::get('birth');
			$account->save();
			
			// Redirect alert
			return Redirect::to('accounts')->with('success', 'Actualizado con éxito!');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Auth
		$userId = Auth::user()->id;
		
		// Find
		$account = Account::where('id', $id)
			->where('user_id', $userId)
			->first();
		
		// Validator Delete
		if ( ! empty($account))
		{
			// Delete
			$account->delete();
		} 
		else 
		{
			// Redirect to the account page.
			return Redirect::to('accounts')->with('error', 'Error registro no existente.');
		}
		
		// Redirect alert
		return Redirect::to('accounts')->with('success', 'Eliminado con éxito!');
	}

}
