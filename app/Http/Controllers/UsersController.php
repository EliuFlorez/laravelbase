<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Controllers\Controller;

use App\User;

use Auth;
use Binput;

class UsersController extends Controller
{
	/**
     * The user repository instance.
     */
    protected $user;
	
	/**
     * Constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
		$this->user = $user;
    }
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		// Search
		$query  = Binput::get('q');
		$sSort  = Binput::get('sort');
		$sOrder = Binput::get('order');
		$aLinks = array();
		
		if ($sSort && $sOrder) {
			$aLinks['sort']  = $sSort;
			$aLinks['order'] = $sOrder;
		}
		
		// Table Sort
		$allowed = array('id', 'name', 'email');
		$sort    = in_array($sSort, $allowed) ? $sSort : 'id';
		
		// header links setup.
		$order = ($sOrder == 'asc') ? 'desc' : 'asc';

		$i = 0 ;
		$attributes = array();
		foreach ($allowed as $allow) {
			$attributes[$i] = array('sort' => $allowed[$i], 'order' => $order);
			$i++;
		}
		
		// get all the user
		if (!empty($query)) {
			$datas = $this->user->where('name', '=', $query)
				->orderBy($sort, $order)
				->paginate(20);
		} else {
			$datas = $this->user->orderBy($sort, $order)
				->paginate(20);
		}
		
		// load the view and pass the user
		return view('users.index', compact('datas', 'attributes', 'aLinks'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		// load the create form (app/views/accounts/create.blade.php)
		return view('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  UserStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(UserStoreRequest $request)
	{
		// store
		$users = new User;
		$users->name     = Binput::get('name');
		$users->email    = Binput::get('email');
		$users->password = bcrypt(Binput::get('password'));
		
		// Save
		$users->save();
		
		// Redirect
		return redirect('admin/users')->with('success', 'Successfully created!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function show($id)
	{
		// get all the user
		$data = $this->user->where('id', '=', $id)->first();
		
		// load the view and pass the user
        return view('users.show')->with('data', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		// get all the user
		$data = $this->user->where('id', '=', $id)->first();
		
		// load the view and pass the user
        return view('users.edit')->with('data', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param  UserUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(UserUpdateRequest $request, $id)
	{
		// Find
		$users = $this->user->where('id', '=', $id)->first();
		
		$users->name  = Binput::get('name');
		$users->email = Binput::get('email');
		
		// Password Change
		if ($password = Binput::get('password')) {
			$users->password = bcrypt($password);
		}
		
		// Save
		$users->save();
		
		// Redirect
        return redirect('admin/users/' . $id . '/edit')->with('success', 'Updated successfully!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
		// Find
		$users = $this->user->where('id', '=', $id)->first();
		
		// Delete
		if (!empty($users)) {
			$users->delete();
			return redirect('admin/users')->with('success', 'Successfully removed!');
		} else {
			return redirect('admin/users')->with('error', 'Error register not exist.');
		}
	}
}
