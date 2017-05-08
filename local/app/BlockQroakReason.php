<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockQroakReason extends \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'block_qroak_reasons';
	
	protected $primaryKey = 'reason_id';
	
	protected $fillable = [ 'reason', 'status' ];
	
	public $timestamps = false;

}
