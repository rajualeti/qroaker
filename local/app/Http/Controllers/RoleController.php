<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use Input;
use App\Permission;
use DB;
use Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class RoleController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	 	$user = Auth::user();
	 	
        if($user->hasRole('admin') || $user->can('view-roles'))
        {
    		$roles = Role::with('createdby')->where('status', '>', -1)->get();
    		
    		return view('roles.index', compact('roles'));
        }
        else
        {
        	return view('errors.403');
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user=Auth::user();
        if($user->hasRole('admin') || $user->can('create-role'))
        {
    		
        	$permissions = Permission::with('childperms')->whereNull('parent')->where('status', 1)->get();
        	
    		return view('roles.create', compact('permissions'));
        }
        else
        {
        	return view('errors.403');
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//echo "<pre>";print_r(Input::all());exit;
		 
		
		$user = Auth::user();
    	if($user->hasRole('admin') || $user->can('create-role'))
    	{
	    	$data = Input::all();
	        $messages = Role::$messages;
	    	$rules = Role::$rules;
	    	
	    	$validator = Validator::make($data, $rules, $messages);
		    
		    if ($validator->fails())
		    {
		        return redirect()->back()->withErrors($validator->errors());
		    } 
		    else {
			    $roles = array(
		        		'name' 			=> str_slug($data['name'], '-'),
			    		'display_name'	=> $data['name'],
			    		'description'	=> $data['description'],
			    		'role_type'		=> $data['role_type'],
			    		'created_by'	=> $user->id
		        );
			    
		        $role_id = Role::insertGetId($roles);
		        
		        foreach($data['checked_perms'] as $perm_id)
		        {
			        $permissions = DB::table('permission_role')->insert(['permission_id' => $perm_id, 'role_id' => $role_id]);
		        }
		        	
		        return redirect('roles')->with('success_message', 'Role created successfully');
		    }
    	}
    	else
    	{
    		return view('errors.403');
    	}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$role = Role::find($id);
		
		$permissions = Permission::with('childperms')->whereNull('parent')->where('status', 1)->get();
		
		$role_permissions = DB::table('permission_role')->where('role_id', $id)->lists('permission_id');
		
		return view('roles.edit', compact('role', 'role_permissions', 'permissions'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = Auth::user();
		
		if($user->hasRole('admin') || $user->can('edit-role'))
		{
			$data = Input::all();
			
			$messages = Role::$messages;
			$rules = Role::$rules;
		
			$rules['name'] = 'required|unique:roles,display_name,'.$id;
				
			$validator = Validator::make($data, $rules, $messages);
		
			if ($validator->fails())
			{
				return redirect()->back()->withErrors($validator->errors());
			}
			else {
				try {
				
					DB::beginTransaction();
					
					$roles = array(
							'name' 			=> str_slug($data['name'], '-'),
							'display_name'	=> $data['name'],
							'description'	=> $data['description'],
							'role_type'		=> $data['role_type']
					);
					 
					$role_id = Role::where('id', $id)->update($roles);
					
					DB::table('permission_role')->where('role_id', $id)->delete();
			
					foreach($data['checked_perms'] as $perm_id)
					{
						$permissions = DB::table('permission_role')->insert(['permission_id' => $perm_id, 'role_id' => $id]);
					}
					
					DB::commit();
					
					return redirect('roles')->with('success_message', 'Role updated successfully');
				
				}
				catch (QueryException $e) {
						
					DB::rollBack();
						
					return redirect()->back()->withInput($data)->withErrors("QueryException: ".$e->getMessage());
				}
					
				catch (\Exception $e) {
						
					DB::rollBack();
						
					return redirect()->back()->withInput($data)->withErrors("Exception: ".$e->getMessage());
				}
			}
		}
		else
		{
			return view('errors.403');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = Auth::user();

		if($user->hasRole('admin') || $user->can('delete-role'))
		{

			$roles = DB::table('role_user')->where('role_id', $id)->get();

			if(empty($roles)) {
				
				try {
				
					DB::beginTransaction();
						
					DB::table('permission_role')->where('role_id', $id)->delete();
						
					DB::table('roles')->where('id', $id)->delete();
					
					DB::commit();
					
					return response(['msg'=>'Role deleted successfully', 'status'=>'success']);
				
				}
				catch (QueryException $e) {
					DB::rollBack();
					return response(['msg'=>'QueryException: '.$e->getMessage(), 'status'=>'failed']);
				}
				catch (\Exception $e) {
					DB::rollBack();
					return response(['msg'=>'Exception: '.$e->getMessage(), 'status'=>'failed']);
				}
					
			}
			else  {
				return response(['msg'=>'Role is asigned to some users. Please remove the role from user', 'status'=>'failed']);
			}

		} else {

			return response(['msg'=>'Access denied!', 'status'=>'failed']);

        }
	}

	public function changeStatus($id) {
		
		$user = Auth::user();
		
		if($user->hasRole('admin') || $user->can('inactivate-role'))
		{
			$status = Input::get('status');
			$affected_rows = Role::where('id', $id)->update(['status' => $status ]);
			
			if ($affected_rows > 0) {
				return response(['msg'=>'Role updated successfully', 'status'=>'success']);
			} else {
				return response(['msg'=>'Role not updated', 'status'=>'failed']);
			}
			
		} else {
			return response(['msg'=>'Access denied!', 'status'=>'failed']);
        }
	}
}
