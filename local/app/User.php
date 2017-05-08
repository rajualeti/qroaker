<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Config;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
	use EntrustUserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name','mobile', 'email','gender','dob','location','user_type','image','status','block_reason_id','blocked_by','blocked_at','is_deleted','additional_info','created_by','created_at','updated_by','updated_at','deleted_by','deleted_at','password', 'remember_token'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public static $rules = [
			'name' 			=> 'required',
			'email' 		=> 'required|email|unique:users,email',
			'gender' 		=> 'required',
			'mobile' 		=> 'required|digits:10|unique:users,mobile',
			'location' 		=> 'required',
	];
	
	public static $messages = [
			'name.required' 		=> 'Name is manditory.',
			'email.required' 		=> 'Email is manditory.',
			'email.email' 			=> 'Email is manditory.',
			'email.unique' 			=> 'This email id is already exists',
			'mobile.required' 		=> 'Mobile is manditory.',
			'mobile.unique' 		=> 'This mobile numner is already exists',
			'mobile.digits' 		=> 'Mobile numner shuold be numeric and length should be 10',
			
	];
	
	public static $password_rules = [
			'id' 						=> 'required|exists:users,id',
			'old_password' 				=> 'required',
			'new_password' 				=> 'required|confirmed',
			'new_password_confirmation'	=> 'required',
				
	];
	
	public static $password_messages = [
			'id.required' 							=> 'The user id required.',
			'id.exists' 							=> 'The user id is not exists in database.', 
			'old_password.required' 				=> 'The old password required.',
			'new_password.required' 				=> 'The new password required.',
			'new_password.confirmed' 				=> 'The new password and confirmation password is not matching.',
			'new_password_confirmation.required' 	=> 'The conformation password required.',
				
	];
	
	public function roles()
	{
		return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
	}
	
}
