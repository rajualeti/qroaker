<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use Config;

class QroakUser extends Model {

	protected $table = 'qroak_users';
	
	protected $primaryKey = 'qroak_user_id';
	
	protected $fillable = [
			'user_id',
			'address',
			'city',
			'status',
			'inactive_reason_id',
			'inactivated_by',
			'inactive_desc',
			'is_deleted',
			'created_at',
			'updated_at'
	];
	
	public static $rules = [
			'name' 			=> 'required',
			'email' 		=> 'required|email|unique:users,email',
			'mobile' 		=> 'required|digits:10|unique:users,mobile',
			'gender' 		=> 'required',
			'dob' 			=> 'required|date',
			'location' 		=> 'required',
			'city' 			=> 'required',
			'secret_pin' 	=> 'required|digits:4',
	];
	
	public static $messages = [
			'city.required' 		=> 'City is mandatory.',
			'name.required' 		=> 'Name is mandatory.',
			'email.required' 		=> 'Email is mandatory.',
			'email.email' 			=> 'Email is not valid.',
			'email.unique' 			=> 'This email id is already exists',
			'mobile.required' 		=> 'Mobile is mandatory.',
			'mobile.unique' 		=> 'This mobile numner is already exists',
			'mobile.digits' 		=> 'Mobile numner shuold be numeric and length should be 10',
				
	];
	
	public static $rules_inactive_qroak_user = [
			'status' => 'required|in:0,1',
			'inactive_reason_id' => 'required|exists:block_qroak_user_reasons,inactive_reason_id',
			'inactivated_by' => 'required|exists:users,id',
			'inactive_desc' => 'required',
	];
	
 	public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
    public static function generateOTP() {
    
    	$numbers = "0123456789012345678901234567890123456789";
    	$otp1 = substr(str_shuffle($numbers),0,2);
    	$otp2 = substr(str_shuffle($numbers),0,2);
    
    	$otp = str_shuffle($otp1.$otp2);
    
    	return $otp;
    }
}
