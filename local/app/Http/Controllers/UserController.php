<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use App\UserRole;
use Illuminate\Database\QueryException;
use DB;
use Config;
use Auth;
use App\State;
use Illuminate\Support\Facades\Mail;
use App\SMS;
use Image;
use App\BlockUserReason;


class UserController extends Controller {
	
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
		$authuser = Auth::user();
			
		if($authuser->hasRole('admin') || $authuser->can('view-users'))
		{
			$users = User::where('is_deleted', 0)->where('user_type', 2)->orderBy('id', 'DESC')->paginate(config('constants.records-per-page'));
			$block_user_reasons = BlockUserReason::where('status', 1)->get();
				
			return view('users.index', compact('users','block_user_reasons'));
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
		$authuser = Auth::user();
			
		if($authuser->hasRole('admin') || $authuser->can('create-user'))
		{
			return view('users.create');
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
		$authuser = Auth::user();
			
		if($authuser->hasRole('admin') || $authuser->can('create-user'))
		{
			$data = Input::all();
			
			$validator = Validator::make($data, User::$rules, User::$messages);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator->errors());
			}
			
			try {
						
				DB::beginTransaction();
				
				$user = User::create([
						'name' 			=> $data['name'],
						'email' 		=> $data['email'],
						'mobile' 		=> $data['mobile'],
						'gender' 		=> $data['gender'],
						'password' 		=> bcrypt($data['password']),
						'location' 		=> $data['location'],
						'status'		=> 1,
						'user_type'		=> 2,
						'created_by' 	=> Auth::id(),
						'created_at'	=> date('Y-m-d H:i:s')
				]);
				
				if(isset($user->id)) {
						
					if ( Input::hasFile('profile_image')) {
							
						$file = Input::file('profile_image');
						$user_name = str_slug($data['name']);
						$name = $user->id.'.png';
						$path = 'images/profile-images/'. $name;
						$image = Image::make($file->getRealPath())->resize(200, 200)->save($path);
						$profile_image = 'images/profile-images/'.$name;
							
						User::where('id', $user->id)->update(['image' => $profile_image]);
					}
					else {
						if(isset($data['profile_caricature']) && !empty($data['profile_caricature'])) {
							User::where('id', $user->id)->update(['image' => $data['profile_caricature']]);
						}
					}
						
					DB::commit();
					
					$mail_to = $data['email'];
					 
					Mail::send('emails.user-registration', compact('data'), function($message) use($mail_to)
					{
						$message->to($mail_to)->subject('Welcome to Qroaker');
					});
					
					return redirect('users')->with('success_message', 'User successfully created. Login details has been sent to the registered email id.');
				
				}
				else {
					DB::rollBack();
						
					return redirect()->back()->withInput($data)->withErrors('Something went wrong');
				}
				
			} 
			catch (QueryException $e) {
				DB::rollBack();
				return redirect()->back()->withInput()->withErrors("Exception: ".$e->getMessage());
			}
			catch (\Exception $e) {
				DB::rollBack();
				return redirect()->back()->withErrors("Exception: ".$e->getMessage());
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
	
        if(Auth::user()->hasRole('admin') || Auth::user()->id == $id)
        {

	    	$profile = User::find($id);
	    	
	    	return view('users.show', compact('profile'));

        }
        else
        {
        	return View('errors.403');
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$logged_user = Auth::user();
		
		if($logged_user->hasRole('admin') || $logged_user->can('edit-user') || ($logged_user->can('edit-own-profile') && $logged_user->id == $id))
		{
			$user = User::find($id);
			
			return view('users.edit', compact('user'));
		}
		else
		{
			return View('errors.403');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$logged_user = Auth::user();
		
		if($logged_user->hasRole('admin') || $logged_user->can('edit-user') || ($logged_user->can('edit-own-profile') && $logged_user->id == $id))
		{
				
			$data = Input::all();
			
	        $rules = User::$rules;
	        $messages = User::$messages;
	        $rules['mobile'] = 'required|digits:10|unique:users,mobile,'.$id;
	        $rules['email'] = 'required|email|unique:users,email,'.$id;
	         
	        $validator = Validator::make($data, $rules, $messages);
	
	        if ($validator->fails())
	        {
	        	return redirect()->back()->withErrors($validator->errors());
	        }
	        else 
	        {
		        try {
					
					DB::beginTransaction();
			        $affected = User::where('id', $id)->update([
							'name' 			=> $data['name'],
							'email' 		=> $data['email'],
							'mobile' 		=> $data['mobile'],
							'gender' 		=> $data['gender'],
							'location' 		=> $data['location'],
							'updated_by' 	=> $logged_user->id,
							'updated_at'	=> date('Y-m-d H:i:s')
					]);
					
					if($affected > 0) {
							
						if ( Input::hasFile('profile_image')) {
								
							$file = Input::file('profile_image');
							$user_name = str_slug($data['name']);
							$name = $id.'.png';
							$path = 'images/profile-images/'. $name;
							$image = Image::make($file->getRealPath())->resize(200, 200)->save($path);
							$profile_image = 'images/profile-images/'.$name;
								
							User::where('id', $id)->update(['image' => $profile_image]);
						}
						else {
							if(isset($data['profile_caricature']) && !empty($data['profile_caricature'])) {
								User::where('id', $id)->update(['image' => $data['profile_caricature']]);
							}
						}
							
						DB::commit();
							
						$mail_to = $data['email'];
				        
				        Mail::send('emails.user-update', compact('data'), function($message) use($mail_to)
				        {
				        	$message->to($mail_to)->subject('Qroaker - Profile updated successfully!');
				        });
			
				        return redirect('users')->with('success_message', 'User successfully updated. Confirmation mail has been sent to registered email id.');
					}
					else {
						DB::rollBack();
							
						return redirect()->back()->withInput($data)->withErrors('Something went wrong');
					}
			        
		        }
		        catch (QueryException $e) {
		        	DB::rollBack();
		        	return redirect()->back()->withInput($data)->withErrors("QueryException: ".$e->getMessage());
		        }
		        catch (\Exception $e) {
		        	DB::rollBack();
		        	return redirect()->back()->withInput($data)->withErrors("Exception: ".$e->getMessage()." in ".$e->getFile()." on line no ".$e->getLine());
		        }
	        }
        }
        else
        {
        	return View('errors.403');
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
		
		if($user->hasRole('admin') || $user->can('delete-user')) {
			 
			if($id) {

				try {
		    
					DB::beginTransaction();

					$deletedata = User::where('id', $id)->update(array('additional_info' => DB::raw('concat(mobile,":",email,":",additional_info )')));
			   
					$delete_user_data = array(
							'is_deleted' 			=> 1,
							'deleted_at'			=> date('Y-m-d H:i:s'),
							'deleted_by' 			=> Auth::id(),
							'mobile' 				=> NULL,
							'email' 				=> NULL,

					);

					$result = User::where('id', $id)->update($delete_user_data);
					
					DB::commit();
			   
					if ($result > 0)
					{
						return response(['msg' => 'User deleted successfully.', 'status' => 'success']);
						 
					}
					else {
			    
						return  response(['msg' => 'Something went wrong. The User is not deleted.', 'status' => 'error']);
					}

				}

				catch (\Exception $e) {
					DB::rollBack();
					return  response(['msg' => 'Expection occured' , 'status' => 'error']);
				}

				catch (\QueryException $e) {
					DB::rollBack();
					return  response(['msg' => 'Query Expection occured' , 'status' => 'error']);
					}
				}
			}
	}
	

	public function blockUser($id) {
		
		$authuser = Auth::user();
		
		if($authuser->hasRole('admin') || $authuser->can('inactivate-user'))
		{

			$data = Input::all();
			
			try {
						
				DB::beginTransaction();

				$affected = User::where('id', $id)->update([
						'status' 			=> 0,
						'blocked_reason_id' => $data['reason_id'],
						'blocked_desc'		=> $data['desc'],
						'blocked_at'		=> date('Y-m-d H:i:s'),
						'blocked_by'		=> $authuser->id
				]);
					
				if ($affected > 0)
				{
					DB::commit();
					return response(['msg' => 'User blocked successfully.', 'status' => 'success']);
				}
				else {
					DB::rollBack();
					return response(['msg' => 'Something went wrong.', 'status' => 'error']);
				}
			}
			catch (QueryException $e) {
				DB::rollBack();
				return response(['msg'=>'QueryException: '.$e->getMessage(), 'status'=>'error']);
			}
			catch (\Exception $e) {
				DB::rollBack();
				return response(['msg'=>'Exception: '.$e->getMessage(), 'status'=>'error']);
			}
		} else {
			return [ 'status' => 'error', 'msg' => 'Access denied!' ];
		}
	}
	
	
	public function unblockUser($id) {
		
		$authuser = Auth::user();
		
		if($authuser->hasRole('admin') || $authuser->can('activate-user'))
		{
			try {
			
				DB::beginTransaction();
			
				$affected = User::where('id', $id)->update([
						'status' 			=> 1,
						'blocked_reason_id' => NULL,
						'blocked_desc'		=> NULL,
						'blocked_at'		=> NULL,
						'blocked_by'		=> NULL
				]);
				 
				if ($affected > 0)
				{
					DB::commit();
					return response(['msg' => 'User unblocked successfully.', 'status' => 'success']);
				}
				else {
					DB::rollBack();
					return response(['msg' => 'Something went wrong.', 'status' => 'error']);
				}
			}
			catch (QueryException $e) {
				DB::rollBack();
				return response(['msg'=>'QueryException: '.$e->getMessage(), 'status'=>'error']);
			}
			catch (\Exception $e) {
				DB::rollBack();
				return response(['msg'=>'Exception: '.$e->getMessage(), 'status'=>'error']);
			}
		} else {
			return [ 'status' => 'error', 'msg' => 'Access denied!' ];
		}
	}
	
}
