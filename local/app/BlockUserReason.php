<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockUserReason extends  \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'block_user_reasons';
	
	protected $primaryKey = 'reason_id';
	
	protected $fillable = [ 'reason', 'status' ];
	
	public $timestamps = false;

}
