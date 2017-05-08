<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Location extends Model {

	protected $table='locations';
	
	protected $primaryKey = 'location_id';
	
	protected $fillable = [
			'area',
			'location',
			'latitude',
			'longitude',
			'state_id',
			'created_by',
			'created_at'
	];
	
	public static $rules = [
			'location' => 'required|unique:locations,location',
			'state_id' => 'required|exists:states,state_id',
	];
	
	public static $messages = [
			'location.required' => 'Location is manditory.',
			'location.unique' => 'Location is already existed.',
			'state_id.required' => 'Location is manditory.',
			'state_id.exists' => 'State is not valid.',
				
	];
	

	public function state()
	{
		return $this->belongsTo('App\State', 'state_id', 'state_id');
	}
	
	
	public static function getOrCreateLocation($data) {
		
		$user = Auth::user();
		if(is_null($user) && isset($data['user'])) {
			$user = $data['user'];
		}
		
		$loc_data = explode(',', $data['location']);
		$count = count($loc_data);
		
		if($count < 3) {
			return false;
		}
		
		$state = State::where('state', trim($loc_data[$count-2]))->first();
		
		if(empty($state)) {
			return false;
		}
		
		$area_name = isset($loc_data[$count-4]) ? trim($loc_data[$count-4]) : NULL;
		$location_name = trim($loc_data[$count-3]);
		
		$location = Location::where('area', $area_name)->where('location', $location_name)->where('state_id', $state->state_id)->first();
		
		if(empty($location)) {
			
			$location = Location::create([
					"area" => $area_name,
					"location" => $location_name,
					"latitude" => $data['latitude'],
					"longitude" => $data['longitude'],
					"state_id" => $state->state_id,
					"created_by" => $user->id,
					"created_at" => date('Y-m-d H:i:s')
					
			]);
		
		}
		
		return $location;
		
	}
	
	public static function getStraightDistance($lat1, $lon1, $lat2, $lon2, $unit = "K") {
	
		//echo $lat1.','.$lon1.','.$lat2.','.$lon2;exit;
	
		$lat1 = floatval($lat1);
		$lon1 = floatval($lon1);
		$lat2 = floatval($lat2);
		$lon2 = floatval($lon2);
	
	
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);
	
		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
	
	public static function getRoadDistance($from, $to)
	{
		$distance = 0;
	
		$from = $from;
		$to = $to;
		$from = urlencode($from);
		$to = urlencode($to);
		$data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false&key=AIzaSyDscCNvBzGZirVBOEbG0Sa99YFJajhFo2s");
		$data = json_decode($data);
	
		if ($data->status == 'OK') {
				
			foreach($data->rows[0]->elements as $road) {
				$distance = $road->distance->value;
			}
				
			$distance = round($distance/1000);
				
			return $distance;
		} else {
			return $distance;
		}
	}
	
	public static function getDistance($data)
	{
		$distance = 0;
		
		if(!isset($data['from_location_id']) || empty($data['from_location_id'])) {
			$from_state_id = State::where('state', $data['from_state'])->pluck('state_id');
			$from_location_id = Location::where('location', $data['from_location'])->where('state_id', $from_state_id)->pluck('location_id');
		}
		else {
			$from_location_id = $data['from_location_id'];
		}
		
		
		if(!isset($data['to_location_id']) || empty($data['to_location_id'])) {
			$to_state_id = State::where('state', $data['to_state'])->pluck('state_id');
			$to_location_id = Location::where('location', $data['to_location'])->where('state_id', $to_state_id)->pluck('location_id');
		}
		else {
			$to_location_id = $data['to_location_id'];
		}
		
		
		$distance = Route::where(function($query) use ($from_location_id, $to_location_id){
	    			$query->where('from_location_id', $from_location_id);
	    			$query->where('to_location_id', $to_location_id);
	    			
	    	})
			->orWhere(function($query) use ($from_location_id, $to_location_id){
	    			$query->where('to_location_id', $from_location_id);
	    			$query->where('from_location_id', $to_location_id);
	    	})
	    	->pluck('distance');
	    
	    if(!empty($distance)) {
	    	return $distance;
	    }

	    
    	$distance = Enquiry::where(function($query) use ($from_location_id, $to_location_id){
	    		$query->where('from_location_id', $from_location_id);
	    		$query->where('to_location_id', $to_location_id);
	    	
	    	})
	    	->orWhere(function($query) use ($from_location_id, $to_location_id){
	    		$query->where('to_location_id', $from_location_id);
	    		$query->where('from_location_id', $to_location_id);
	    	})
	    	->pluck('distance');
    	
		
	    
		if(!empty($distance)) {
	    	return $distance;
	    }
    	
	    
    	$distance = Order::where(function($query) use ($from_location_id, $to_location_id){
	    		$query->where('from_location_id', $from_location_id);
	    		$query->where('to_location_id', $to_location_id);
	    
	    	})
	    	->orWhere(function($query) use ($from_location_id, $to_location_id){
	    		$query->where('to_location_id', $from_location_id);
	    		$query->where('from_location_id', $to_location_id);
	    	})
	    	->pluck('distance');
	    
	    
		if(!empty($distance)) {
	    	return $distance;
	    }

	    
    	$distance = Booking::where(function($query) use ($from_location_id, $to_location_id){
	    		$query->where('from_location_id', $from_location_id);
	    		$query->where('to_location_id', $to_location_id);
	    	  
	    	})
	    	->orWhere(function($query) use ($from_location_id, $to_location_id){
	    		$query->where('to_location_id', $from_location_id);
	    		$query->where('from_location_id', $to_location_id);
	    	})
	    	->pluck('distance');
	    	 
	    
	    if(empty($distance)) {
	    	
	    	$distance = Location::getRoadDistance($data['from_location'].', '.$data['from_state'], $data['to_location'].', '.$data['to_state']);
	    
	    }
	    
		return $distance;
	}
}
