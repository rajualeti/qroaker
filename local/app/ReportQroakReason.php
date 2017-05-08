<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportQroakReason extends  \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'report_qroak_reasons';
	
	protected $primaryKey = 'reason_id';
	
	protected $fillable = [ 'reason', 'status' ];
	
	public $timestamps = false;

}
