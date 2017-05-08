<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;


class Setting extends \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'settings';
    
    protected $primaryKey = 'setting_id';
    
    protected $fillable = [ 'setting_id', 'name', 'key', 'value', 'status' ];
    
    
    public static function getAllSettings()
    {
    	$system_variables = Setting::where('status', 1)->get();
    	 
    	foreach($system_variables as $system_variable)
    	{
    		Config::set('constants.'.$system_variable->key, $system_variable->value);
    	}
    	
    	return $system_variables;
    }

}
