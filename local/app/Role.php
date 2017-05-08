<?php 

namespace App;
use Zizaco\Entrust\EntrustRole;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Role extends EntrustRole 
{

	protected $table = 'roles';
    
    protected $primaryKey = 'id';
    
    protected $fillable = ['name', 'display_name', 'description', 'role_type', 'status', 'created_at'];
    
    public static $rules = [
			'name' 			=> 'required|unique:roles,display_name',
    		'checked_perms'	=> 'required|min:1',
	];
    
    public static $messages = [
    		'name.required' 			=> 'Role name is mandatory.',
    		'name.unique'   			=> 'The role has already been taken.',
    		'checked_perms.required' 	=> 'Select atleast one task.',
    		'checked_perms.min'   		=> 'Select atleast one task.',
    		
    ];
    
	public function createdby()
    {
    	return $this->belongsTo('App\User', 'created_by', 'id');
    }
    
    public function permissions()
    {
    	return $this->belongsToMany('App\Permission', 'permission_role', 'role_id', 'permission_id');
    }
}
