<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCommentReason extends  \SleepingOwl\Models\SleepingOwlModel {

	protected $table = 'report_comment_reasons';
	
	protected $primaryKey = 'reason_id';
	
	protected $fillable = [ 'reason', 'status' ];
	
	public $timestamps = false;

}
