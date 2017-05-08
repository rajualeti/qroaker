<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;

class SMS extends Model
{
	
	public static function sendSMS($mobile, $message)
	{/* 
		
		if(config('constants.sms-switch')){
			
			$url 		= config('constants.sms-url');
			$username 	= config('constants.sms-username');
			$key 		= config('constants.sms-api-key');
			$sid		= config('constants.sms-sender-id');
			
			$request 	= $url.'?user='.$username.'&apikey='.$key.'&mobile='.$mobile.'&message='.urlencode($message).'&senderid='.urlencode($sid).'&type=uni';
			
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $request);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);
			curl_close($ch);
			
	
			if($response) {
				
				if(is_numeric(trim($response))) {
					
					
					 $status = SMS::getSMSStatus($response);
					 
					
					return true;
					
			    } else {
			    	
			        return false;
			        
			    }
				
			}
		
		}

	 */}
	
	
	public static function getSMSStatus( $msgid = '' )
	{
		
		$msgid = urlencode($msgid);
		
		$url 		= config('constants.sms-delivery-report-url');
		$username 	= config('constants.sms-username');
		$key 		= config('constants.sms-api-key');
		
		$request 	= $url.'?user='.$username.'&apikey='.$key.'&msgid='.$msgid.'';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $request);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	

}
