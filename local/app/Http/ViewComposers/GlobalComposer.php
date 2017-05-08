<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\Employee;

class GlobalComposer {

	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		$view->with('ID', false);
		$view->with('ProfileLink', false);
		$view->with('Logo', false);
		$view->with('CompanyCity', false);
		$view->with('Name', false);
		
		if (Auth::check()) {
			
			$user = Auth::user();
			 
			$view->with('ID', $user->id);
			$view->with('ProfileLink', 'users/'.$user->id);
			$view->with('Logo', false);
			$view->with('CompanyCity', false);
			$view->with('Name', $user->name);
			
		}
	}

}