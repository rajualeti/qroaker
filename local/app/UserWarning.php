<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWarning extends  \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'user_warnings';
	
	protected $primaryKey = 'warning_id';
	
	protected $fillable = [ 'warning', 'status' ];
	
	public $timestamps = false;

}
