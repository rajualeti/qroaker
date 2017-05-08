<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'states';
	
	protected $primaryKey = 'state_id';
	
	protected $fillable = [ 'state_id', 'state', 'status' ];
	
	
	public static function getStateByName($state){
		
		return State::where('state', $state)->first();
		
	}

}
