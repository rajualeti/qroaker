<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportProfileReason extends  \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'report_profile_reasons';
	
	protected $primaryKey = 'reason_id';
	
	protected $fillable = [ 'reason', 'status' ];
	
	public $timestamps = false;

}
