<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use App\Role;
use Auth;
use Mail;
use Validator;
use DB;
use App\User;
use Illuminate\Database\QueryException;
use Intervention\Image\Facades\Image;
use Config;
use App\QroakUser;
use Illuminate\Support\Facades\File;

class QroakUserController extends Controller {

	/**
	* Checking the customer login.
	*/
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
		
		if($user->can('view-qroakusers') || $user->hasRole('admin')) {
			
			$qroakusers = QroakUser::where('is_deleted', 0)->orderby('qroak_user_id', 'DESC')->paginate(Config::get('constants.records-per-page'));
			$block_qroakuser_reasons = [];
			
			return view('qroakusers.index', compact('qroakusers', 'users', 'block_qroakuser_reasons'));
		} 
		else {
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
		$user = Auth::user();
		
		if($user->can('create-qroakuser') || $user->hasRole('admin')) {
		
			$roles = Role::where('status', 1)->where('role_type', 1)->orderby('name', 'asc')->get();
			 
			return view('qroakusers.create', compact('roles'));
		}
		else {
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
		$user = Auth::user();
		
		if($user->can('create-qroakuser') || $user->hasRole('admin')) {
		
			$data = Input::all();
			
			$user_data = [
						'name' 			=> $data['name'],
						'email' 		=> $data['email'],
						'mobile' 		=> $data['mobile'],
						'gender' 		=> $data['gender'],
						'dob'			=> date('Y-m-d', strtotime($data['dob'])),
						'password' 		=> bcrypt($data['password']),
						'location' 		=> $data['location'],
						'status'		=> 1,
						'user_type'		=> 1,
						'created_by' 	=> Auth::id(),
						'created_at'	=> date('Y-m-d H:i:s')
			];
			
			$validator = Validator::make($user_data, QroakUser::$rules, QroakUser::$messages);
			
			if ($validator->fails()) {
			
				return redirect()->back()->withInput($data)->withErrors($validator->errors());
			
			}
			
			try {
				
				DB::beginTransaction();
					
				$user = User::create($user_data);
				
				if(isset($data['checked_roles']) && count($data['checked_roles']) > 0) {
					$user_roles = array();
					foreach ($data['checked_roles'] as $role_id) {
						$user_role['role_id'] = $role_id;
						$user_role['user_id'] = $user->id;
						
						array_push($user_roles, $user_role);
					}
			
					DB::table('role_user')->insert($user_roles);
				}
				
				
				$qroakuser = QroakUser::create([
						'user_id' 			=> $user->id,
						'status'			=> 1,
						'address' 			=> $data['address'],
						'city' 				=> $data['city'],
						'created_at'		=> date('Y-m-d H:i:s')
				]);
				
				
				if(isset($qroakuser->qroak_user_id)) {
					
					if ( Input::hasFile('profile_image')) {
							
						$file = Input::file('profile_image');
						$user_name = str_slug($data['name']);
						$name = $user->id.'.png';
						$path = 'images/profile-images/'. $name;
						$image = Image::make($file->getRealPath())->resize(200, 200)->save($path);
						$profile_image = 'images/profile-images/'.$name;
					
						User::where('id', $user->id)->update(['image' => $profile_image]);
					}
					
					DB::commit();
					
					$mail_to = $data['email'];
					Mail::send('emails.qroakuser-registration', compact('data'), function($message) use($mail_to)
					{
						$message->to($mail_to)->subject('Welcome to Qroaker!');
					});
					
					return redirect('qroak-users')->with('success_message', 'Qroak user successfully created. Login details has been sent to the registered email id.');
				}
				else {
					DB::rollBack();
			
					return redirect()->back()->withInput($data)->withErrors('Something went wrong');
				}
			}
			catch (QueryException $e) {
				DB::rollBack();
				return redirect()->back()->withInput($data)->withErrors("QueryException: ".$e->getMessage()." on file ".$e->getFile().' in line no '.$e->getLine());
			}
			catch (\Exception $e) {
				DB::rollBack();
				return redirect()->back()->withInput($data)->withErrors("Exception: ".$e->getMessage()." on file ".$e->getFile().' in line no '.$e->getLine());
			}
		} else {
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
		$user = Auth::user();
		
		$profile = QroakUser::find($id);
				
		if($user->can('view-qroakusers') || $user->hasRole('admin') || $user->id == $profile->user_id)
		{
			return view('qroakusers.show', compact('profile'));
		}
		else
		{
			return view('errors.403');
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
		$user = Auth::user();
		$user_id = QroakUser::find($id)->user_id;
		
		if($user->hasRole('admin') || ($user->can('edit-qroakuser') && ($user->id == $user_id || $user->user_type == 1)))			
		{	
			$users = User::with('roles')->get();
			
			$qroakuser = QroakUser::find($id);
			$roles = Role::where('status', 1)->where('role_type', 1)->orderby('name', 'asc')->get();
			$user_roles = DB::table('role_user')->where('user_id', $user_id)->lists('role_id');
				
			return view('qroakusers.edit', compact('qroakuser', 'roles', 'user_roles'));
		} else {
			return view('errors.403');
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
		$user = Auth::user();
		$user_id = QroakUser::find($id)->user_id;
		
		if($user->hasRole('admin') || ($user->can('edit-qroakuser')  && ($user->id == $user_id || $user->user_type == 1))) 
		{
		
			$data = Input::all();
			$user_id = QroakUser::find($id)->user_id;
				
			$user_rules = User::$rules;
			$user_messages = User::$messages;
			$user_rules['mobile'] = 'required|digits:10|unique:users,mobile,'.$user_id;
			$user_rules['email'] = 'required|email|unique:users,email,'.$user_id;
			
			$user_data = [
						'name' 			=> $data['name'],
						'gender' 		=> $data['gender'],
						'dob'			=> date('Y-m-d', strtotime($data['dob'])),
						'email' 		=> $data['email'],
						'mobile' 		=> $data['mobile'],
						'location' 		=> $data['location'],
						'updated_by' 	=> Auth::id(),
						'updated_at'	=> date('Y-m-d H:i:s')
			];
			
			$validator = Validator::make($user_data, $user_rules, $user_messages);
			
			if ($validator->fails()) {
				return redirect()->back()->withInput($data)->withErrors($validator->errors());
			}
			
			try {
					
				DB::beginTransaction();
			
				$user = User::where('id', $user_id)->update($user_data);
				
				$affected_rows = QroakUser::where('qroak_user_id', $id)->update([
						'address' 			=> $data['address'],
						'city' 				=> $data['city'],
						'updated_at'		=> date('Y-m-d H:i:s')
				]);
				
				if($affected_rows > 0) {
					
					if ( Input::hasFile('profile_image')) {
							
						$file = Input::file('profile_image');
						$user_name = str_slug($data['name']);
						$name = $user_id.'.png';/* $file->getClientOriginalExtension(); */
						$path = 'images/profile-images/'. $name;
						$image = Image::make($file->getRealPath())->resize(200, 200)->save($path);
						$profile_image = 'images/profile-images/'.$name;
					
						//File::delete('images/'.User::find($user_id)->image);
						
						User::where('id', $user_id)->update(['image' => $profile_image]);
					}
					
					DB::commit();
					
					$mail_to = $data['email'];
					
					Mail::send('emails.qroakuser-update', compact('data'), function($message) use($mail_to)
					{
						$message->to($mail_to)->subject('Qroaker - Profile updated successfully');
					});
			
					return redirect('qroak-users')->with('success_message', 'Qroak User updated successfully. Confirmation mail has been sent to the registered email id.');
				}
				else {
					DB::rollBack();
					return redirect()->back()->withInput($data)->withErrors('Profile not updated.');
				}
			}
			catch (QueryException $e) {
				DB::rollBack();
				return redirect()->back()->withInput($data)->withErrors("QueryException: ".$e->getMessage());
			}
			catch (\Exception $e) {
				DB::rollBack();
				return redirect()->back()->withInput($data)->withErrors("Exception: ".$e->getMessage());
			}
		} else {
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
		
		if($user->can('delete-qroakuser') || $user->hasRole('admin')) {
			
			$qroakuser = QroakUser::find($id);
			
			try {
					
				DB::beginTransaction();
			
				QroakUser::where('qroak_user_id', $id)->update([
						'is_deleted'		=> 1
				]);
				
				User::where('id', $qroakuser->user_id)->update([
						'is_deleted'		=> 1,
						'mobile'			=> NULL,
						'email'				=> NULL,
						'additional_info'	=> $qroakuser->user->additional_info.':'.$qroakuser->user->mobile.':'.$qroakuser->user->email,
						'deleted_by' 		=> Auth::id(),
						'deleted_at'		=> date('Y-m-d H:i:s')
				]);
				
				DB::commit();
				
				return [ 'status' => 'success', 'msg' => 'Qroak User deleted successfully' ];
				
			}
			catch (QueryException $e) {
				DB::rollBack();
				return response(['msg'=>'QueryException: '.$e->getMessage(), 'status'=>'failed']);
			}
			catch (\Exception $e) {
				DB::rollBack();
				return response(['msg'=>'Exception: '.$e->getMessage(), 'status'=>'failed']);
			}
		} else {
			return [ 'status' => 'error', 'msg' => 'Access denied!' ];
		}
	}
	
	
	public function changeStatus($id) {
	
		$user = Auth::user();
	
		if($user->hasRole('admin') || $user->can('inactivate-qroakuser'))
		{
			DB::beginTransaction();
			
			$status = Input::get('status');
			$affected_rows = QroakUser::where('qroak_user_id', $id)->update(['status' => $status ]);
	
			if ($affected_rows > 0) {
				User::where('id', QroakUser::find($id)->user_id)->update(['status' => $status ]);
				DB::commit();
				return response(['msg'=>'User updated successfully', 'status'=>'success']);
			} else {
				DB::rollBack();
				return response(['msg'=>'Error occured!', 'status'=>'failed']);
			}
		} else {
			return response(['msg'=>'Access denied!', 'status'=>'failed']);
		}
	}
	
}
