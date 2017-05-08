<?php

use App\Location;
use App\Customer;
use App\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\TruckType;
use App\Material;
use Carbon\Carbon;

if (!function_exists('format_price')) {

	function format_price($value)
	{
		$format = new NumberFormatter( 'en_IN', NumberFormatter::DECIMAL);
		
		return $format->formatCurrency($value, "INR");
	}
}


if (!function_exists('format_date')) {

	function format_date($date)
	{
		return date('d M Y', strtotime($date));
	}
}


if (!function_exists('format_time')) {

	function format_time($time)
	{
		return date('g:i A', strtotime($time));
	}
}


if (!function_exists('format_datetime')) {

	function format_datetime($datetime)
	{
		return date('d M Y g:i A', strtotime($datetime));
	}
}

if (!function_exists('location')) {

	function location($location_id, $state_flag = false, $country_flag = false)
	{
		$location = Location::with('state')->where('location_id', $location_id)->first();
		
		$area = (is_null($location->area) ? '' : $location->area.', ');
		$city = $location->location;
		$state = ($state_flag) ? ', '.$location->state->state : '';
		$country = ($country_flag) ? ', India' : '';
		
		return $area.$city.$state.$country;
	}
}


if (!function_exists('print_array_exit')) {

	function print_array_exit($array)
	{
		echo "<pre>";print_r($array);exit;
	}
}

if (!function_exists('print_json_exit')) {

	function print_json_exit($array)
	{
		echo json_encode($array);exit;
	}
}


if (!function_exists('percentage')) {

	function percentage($value1, $value2)
	{
		return round(($value1/$value2)*100, 2).'%';
	}
}


if (!function_exists('timediff')) {

	function timediff($date1, $date2)
	{
		$time1 = new Carbon($date1);
		$time2 = new Carbon($date2);
		
		$days = $time1->diffInDays($time2);
		$hours = $time1->diffInHours($time2->copy()->subDays($days));
		$mins = $time1->diffInMinutes($time2->copy()->subDays($days)->subHours($hours));
		
		$diff = '';
		
		if($days) {
			$diff .= $days.'d, ';
		}
		
		if($hours) {
			$diff .= (strlen($hours) == 1 ? '0'.$hours.'h, ' : $hours.'h, ');
		}
		
		if($mins) {
			$diff .= (strlen($mins) == 1 ? '0'.$mins.'m, ' : $mins.'m');
		}
		
		return ($diff == '' ? '0' : trim($diff,', '));
	}
}

if (!function_exists('gender')) {

	function gender($value)
	{
		if($value == 1) {
			return 'Male';
		} else if($value == 2) {
			return 'Female';
		} else {
			return 'Other';
		}
	}
}

if (!function_exists('generatepassword')) {
	
	function generatepassword() {
		
		$numbers = "0123456789";
	
		return substr(str_shuffle($numbers),0,4);
	}
}

if (!function_exists('convert_hashtag')) {

	function convert_hashtag($str) {

		$regex = "/#+([a-zA-Z0-9_]+)/";
		
		return preg_replace($regex, '<a href="?tag=$1" class="hash-link">$0</a>', $str);
	}
}
