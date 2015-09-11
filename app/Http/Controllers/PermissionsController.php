<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Controllers\Controller;

use App\User;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

use Auth;
use Binput;
use Validator;

class PermissionsController extends Controller
{
	/**
     * The user repository instance.
     */
    protected $permission;
	
	/**
     * Constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
		$this->permission = $permission;
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
		
		if (!empty($uid)) {
			$aLinks['uid'] = $uid;
		}
		
		// Table Sort
		$allowed = array('id', 'name', 'slug', 'model', 'description');
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
		
		// get all the permission
		if (!empty($query)) {
			$datas = $this->permission->where('name', '=', $query)
				->orderBy($sort, $order)
				->paginate(20);
		} else {
			$datas = $this->permission->orderBy($sort, $order)
				->paginate(20);
		}
		
		// load the view and pass the permission
		return view('permissions.index', compact('datas', 'attributes', 'aLinks', 'uid'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		// Roles Select
		$roles = Role::all();
		$roleSelect = array();
		$roleSelect[0] = '';
		foreach($roles as $role) {
			$roleSelect[$role['id']] = $role['name'];
		}
		
		// load the create form (app/views/accounts/create.blade.php)
		return view('permissions.create', compact('roleSelect'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  PermissionStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(PermissionStoreRequest $request)
	{
		// store
		$permissions = new Permission;
		$permissions->name        = Binput::get('name');
		$permissions->slug        = Binput::get('slug');
		$permissions->description = Binput::get('description');
		$permissions->model       = Binput::get('model');
		
		// Save
		$permissions->save();
		
		// Roles Permission
		if ($role_id = Binput::get('role_id')) {
			$role = Role::find($role_id);
			$role->attachPermission($permissions->id);
		}
		
		// Redirect
		return redirect('admin/permissions')->with('success', 'Successfully created!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function show($id)
	{
		// get all the permission
		$data = $this->permission->where('id', '=', $id)->first();
		
		// load the view and pass the permission
        return view('permissions.show')->with('data', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		// Roles Select
		$roles = Role::all();
		$roleSelect = array();
		$roleSelect[0] = '';
		foreach($roles as $role) {
			$roleSelect[$role['id']] = $role['name'];
		}
		
		// get all the permission
		$data = $this->permission->where('id', '=', $id)->first();
		$role = DB::table('permission_role')->where('permission_id', '=', $id)->first();
		
		$role_id = null;
		if (!empty($role)) {
			$role_id = $role->role_id;
		}
		
		// load the view and pass the permission
        return view('permissions.edit', compact('data', 'role_id', 'roleSelect'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param  PermissionUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(PermissionUpdateRequest $request, $id)
	{
		// Find
		$permissions = $this->permission->where('id', '=', $id)->first();
		
		$permissions->name        = Binput::get('name');
		$permissions->slug        = Binput::get('slug');
		$permissions->description = Binput::get('description');
		$permissions->model       = Binput::get('model');
		
		// Save
		$permissions->save();
		
		// Roles Permission
		if ($role_id = Binput::get('role_id')) {
			$role = Role::find($role_id);
			$role->attachPermission($permissions->id);
		}
		
		// Redirect
        return redirect('admin/permissions/' . $id . '/edit')->with('success', 'Updated successfully!');
	}

	/**
	 * Add / Remove - Permissions.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function anyUsers()
	{
		// Validator
		$validator = Validator::make(Binput::all(), [
            'user_id'   => 'required',
            'permission_id' => 'required',
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
			$permission_id = Binput::get('permission_id');
			
			// Users ID
			$user = User::find($user_id);
			
			// Data
			$data = [];
			
			// Add Permission
			if (!empty($user)) {
				if ($permission_id === 'ALL') {
					$permission = $user->detachAllPermissions();
				} else {
					$permission = $user->attachPermission($permission_id);
				}
				
				if ($permission) {
					$data = array(
						'success' => true,
						'message' => 'Add Permission'
					);
				} else {
					$data = array(
						'success' => false,
						'message' => 'Error Add Permission'
					);
				}
			} else {
				$data = array(
					'success' => false,
					'message' => 'Error Add Permission'
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
		$permissions = $this->permission->where('id', '=', $id)->first();
		
		// Delete
		if (!empty($permissions)) {
			$permissions->delete();
			return redirect('admin/permissions')->with('success', 'Successfully removed!');
		} else {
			return redirect('admin/permissions')->with('error', 'Error register not exist.');
		}
	}
}
