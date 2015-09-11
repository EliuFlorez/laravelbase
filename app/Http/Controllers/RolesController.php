<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Controllers\Controller;

use App\User;
use Bican\Roles\Models\Role;

use Auth;
use Binput;
use Validator;

class RolesController extends Controller
{
	/**
     * The user repository instance.
     */
    protected $role;
	
	/**
     * Constructor.
     *
     * @param Role $role
     */
    public function __construct(Role $role)
    {
		$this->role = $role;
    }
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		// Search
		$uid    = Binput::get('uid');
		$query  = Binput::get('q');
		$sSort  = Binput::get('sort');
		$sOrder = Binput::get('order');
		$aLinks = array();
		
		if ($sSort && $sOrder) {
			$aLinks['sort']  = $sSort;
			$aLinks['order'] = $sOrder;
		}
		
		// Table Sort
		$allowed = array('id', 'name', 'slug', 'level', 'description');
		$sort    = in_array($sSort, $allowed) ? $sSort : 'id';
		
		// header links setup.
		$order = ($sOrder == 'asc') ? 'desc' : 'asc';

		$i = 0 ;
		$attributes = array();
		foreach ($allowed as $allow) {
			$params = array('sort' => $allowed[$i], 'order' => $order);
			if (!empty($uid)) {
				$params['uid'] = $uid;
			}
			$attributes[$i] = $params;
			$i++;
		}
		
		// get all the role
		if (!empty($query)) {
			$datas = $this->role->where('name', '=', $query)
				->orderBy($sort, $order)
				->paginate(20);
		} else {
			$datas = $this->role->orderBy($sort, $order)
				->paginate(20);
		}
		
		// load the view and pass the role
		return view('roles.index', compact('datas', 'attributes', 'aLinks', 'uid'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		// load the create form (app/views/accounts/create.blade.php)
		return view('roles.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  RoleStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(RoleStoreRequest $request)
	{
		// store
		$roles = new Role;
		$roles->name        = Binput::get('name');
		$roles->slug        = Binput::get('slug');
		$roles->description = Binput::get('description');
		$roles->level       = Binput::get('level');
		
		// Save
		$roles->save();
		
		// Redirect
		return redirect('admin/roles')->with('success', 'Successfully created!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function show($id)
	{
		// get all the role
		$data = $this->role->where('id', '=', $id)->first();
		
		// load the view and pass the role
        return view('roles.show')->with('data', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		// get all the role
		$data = $this->role->where('id', '=', $id)->first();
		
		// load the view and pass the role
        return view('roles.edit')->with('data', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param  RoleUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(RoleUpdateRequest $request, $id)
	{
		// Find
		$roles = $this->role->where('id', '=', $id)->first();
		
		$roles->name        = Binput::get('name');
		$roles->slug        = Binput::get('slug');
		$roles->description = Binput::get('description');
		$roles->level       = Binput::get('level');
		
		// Save
		$roles->save();
		
		// Redirect
        return redirect('admin/roles/' . $id . '/edit')->with('success', 'Updated successfully!');
	}

	/**
	 * Add / Remove - Roles.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function anyUsers()
	{
		// Validator
		$validator = Validator::make(Binput::all(), [
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

		// Fails Return
        if ($validator->fails()) {
			return response()->json(array(
                'success' => false,
                'message' => $validator->errors()
            ));
		} else {
			// Var
			$user_id = Binput::get('user_id');
			$role_id = Binput::get('role_id');
			
			// Users ID
			$user = User::find($user_id);
			
			// Data
			$data = [];
			
			if (!empty($user)) {
				// Add Role
				if ($role_id === 'ALL') {
					$role = $user->detachAllRoles();
				} else {
					$role = $user->attachRole($role_id);
				}
				
				if ($role) {
					$data = array(
						'success' => true,
						'message' => 'Add Role'
					);
				} else {
					$data = array(
						'success' => false,
						'message' => 'Error add Role'
					);
				}
			} else {
				$data = array(
					'success' => false,
					'message' => 'Error add Role'
				);
			}
			
			// Response JSON
			return response()->json($data);
		}
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
		$roles = $this->role->where('id', '=', $id)->first();
		
		// Delete
		if (!empty($roles)) {
			$roles->delete();
			return redirect('admin/roles')->with('success', 'Successfully removed!');
		} else {
			return redirect('admin/roles')->with('error', 'Error register not exist.');
		}
	}
}
