<?php 

namespace App;
use DB;
use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\Model;

class Permission extends EntrustPermission {

	protected $table = 'permissions';
	
	protected $primaryKey = 'id';
	
	protected $fillable = ['name', 'parent', 'display_name', 'description', 'role_type', 'status', 'created_at', 'updated_at'];
	
	public function childperms()
	{
		return $this->hasMany('App\Permission', 'parent', 'id');
	}
	
}
