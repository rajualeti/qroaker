<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Qroak extends Model {

	protected $table = 'qroaks';
	
	protected $primaryKey = 'qroak_id';
	
	protected $fillable = [
			'user_id',
			'qroak_text',
			'is_classified',
			'is_private',
			'status',
			'block_reason_id',
			'blocked_by',
			'blocked_at',
			'created_at',
			'updated_at'
	];

	public static $rules = [
			'qroak_text' 	=> 'required',
			'is_classified' => 'required|in:0,1',
			'is_private' 	=> 'required|in:0,1',
	];
	
	public static $messages = [
			'qroak_text.required' 		=> 'City is mandatory.',
			'is_classified.required' 	=> 'Name is mandatory.',
			'is_private.required' 		=> 'Email is mandatory.',
	
	];
	
	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'id');
	}
}
